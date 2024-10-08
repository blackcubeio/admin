import {
    ICustomElementViewModel,
    IPlatform,
    customElement,
    bindable,
    INode,
    BindingMode,
    IEventAggregator,
    ILogger,
    IDisposable,
    resolve
} from 'aurelia';
import Resumable from "resumablejs"
import URI from 'urijs';
import {Csrf, IHttpService} from "../services/http-service";

interface UploadedFile {
    name:string,
    shortname:string|undefined,
    previewUrl:string,
    deleteUrl:string,
    file?:Resumable.ResumableFile|null
}
@customElement('blackcube-file-upload')
export class File
{
    private resumable:Resumable;
    private browse:HTMLDivElement;
    private drop:HTMLDivElement;
    private parentForm:HTMLFormElement;
    private icon: HTMLElement;
    public hiddenField:HTMLInputElement;
    private handledFiles:UploadedFile[];
    private csfr:Csrf;
    private uploadCount = 0;
    public fileInfo: string;

    @bindable() public uploadUrl: string;
    @bindable() public previewUrl: string;
    @bindable() public deleteUrl: string;
    @bindable() public fileType: string = '';
    @bindable() public name: string;
    @bindable() public multiple: string|boolean = false;
    @bindable() public value: string = '';
    @bindable() public imageWidth: string;
    @bindable() public imageHeight: string;
    @bindable() public title: string;
    @bindable() public uploadFileText: string;
    @bindable() public uploadFileDnd: string;
    @bindable() public uploadFileDescription: string;
    @bindable() public error: boolean = false;

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('File'),
        private readonly httpService:IHttpService = resolve(IHttpService),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly element: Element = resolve(INode) as Element,
    ) {
        this.logger = logger.scopeTo('File');
    }

    private appendParametersUrl(url:string)
    {
        let baseUrl = new URI(url);
        if (this.imageWidth) {
            baseUrl.addSearch({width: this.imageWidth});
        }
        if (this.imageHeight) {
            baseUrl.addSearch({height: this.imageHeight});
        }
        return baseUrl.toString();
    }

    private generatePreviewUrl(name:string)
    {
        let url = this.previewUrl.replace('__name__', name);
        return this.appendParametersUrl(url);
    }

    private generateDeleteUrl(name:string)
    {
        return this.deleteUrl.replace('__name__', name);
    }

    private setFiles(value:string)
    {
        let files = value.split(/\s*,\s*/);
        this.handledFiles = files.filter((value:string, index:number) => {
            return value.trim() !== '';
        }).map((value:string, index:number) => {
            return {
                name: value,
                shortname: value.split(/.*[\/|\\]/).pop(),
                previewUrl: this.generatePreviewUrl(value),
                deleteUrl: this.generateDeleteUrl(value)
            }
        });
        this.hiddenField.value = this.getFilesValue();

    }

    private setFile(name:string, file:Resumable.ResumableFile|null = null)
    {
        this.handledFiles.forEach((handledFile:UploadedFile, index:number) => {
            if (handledFile.file && handledFile.file !== null) {
                this.resumable.removeFile(handledFile.file);
            }
            this.httpService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
        });
        this.handledFiles = [
            {
                name: name,
                shortname: name.split(/.*[\/|\\]/).pop(),
                previewUrl: this.generatePreviewUrl(name),
                deleteUrl: this.generateDeleteUrl(name),
                file: file
            }
        ];
        this.hiddenField.value = this.getFilesValue();

    }

    private appendFile(name:string, file:Resumable.ResumableFile|null = null)
    {
        this.handledFiles.push({
            name: name,
            shortname: name.split(/.*[\/|\\]/).pop(),
            previewUrl: this.generatePreviewUrl(name),
            deleteUrl: this.generateDeleteUrl(name),
            file: file
        });
        this.hiddenField.value = this.getFilesValue();

    }
    protected getFilesValue()
    {
        let mapped = this.handledFiles.map((uploadedFile: UploadedFile, index:number) => {
            return uploadedFile.name;
        }).join(', ');
        return (typeof mapped === 'string') ? mapped : '';
    }

    public onRemove(handledFile:UploadedFile, evt:Event)
    {
        evt.stopPropagation();
        evt.preventDefault();
        this.logger.debug('Should remove file', handledFile);
        let fileIndex:number|null = null;
        this.handledFiles.forEach((file:UploadedFile, index:number) => {
            if (handledFile.name === file.name) {
                fileIndex = index;
            }
        });
        if (fileIndex !== null && fileIndex >= 0) {
            if (handledFile.file && handledFile.file !== null) {
                this.resumable.removeFile(handledFile.file);
            }
            this.handledFiles.splice(fileIndex, 1);
            this.httpService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
            // should call WS delete
        }
        let fieldValue = this.getFilesValue();
        this.hiddenField.value = fieldValue;

    }

    public attached() :void
    {
        this.setUp();
    }

    private setUp(): void {
        this.parentForm = <HTMLFormElement>this.element.closest('form');
        this.logger.debug('Multiple', this.multiple);
        let resumableConfig:Resumable.ConfigurationHash = {
            target: this.uploadUrl,
            chunkSize: 512 * 1024
        };
        let fileTypes = this.fileType.split(/\s*,\s*/).filter((value:string, index:number) => {
            return value.trim() !== '';
        });
        this.fileInfo = fileTypes.map((item:string) => {return item.toLocaleUpperCase(); }).join(', ');
        resumableConfig.fileType = fileTypes;
        if (this.parentForm) {
            let csrfField = <HTMLInputElement>this.parentForm.querySelector('input[name=_csrf]');
            this.csfr = {
                name: csrfField.name,
                value: csrfField.value
            };
            resumableConfig.query = {};
            // @ts-ignore
            resumableConfig.query[this.csfr.name] = this.csfr.value;
            this.logger.debug('CSRF : ', csrfField.value);
        }
        this.hiddenField = document.createElement('input');
        this.hiddenField.type = 'hidden';
        this.hiddenField.name = this.name;
        this.element.appendChild(this.hiddenField);
        this.setFiles(this.value);
        this.resumable = new Resumable(resumableConfig);
        if (this.resumable.support) {
            // this.logger.debug('Resume js supported', this.browse);
            this.resumable.assignBrowse(this.browse, false);
            this.resumable.assignDrop(this.drop);
            this.drop.addEventListener('dragover', this.onDragEnter);
            this.drop.addEventListener('dragenter', this.onDragEnter);
            this.drop.addEventListener('dragleave', this.onDragLeave);
            this.drop.addEventListener('drop', this.onDragLeave);
            // this.resumable.assignDrop(this.dropTarget);
            this.resumable.on('fileAdded', this.onFileAdded);
            this.resumable.on('fileSuccess', this.onFileSuccess);
            this.resumable.on('fileProgress', this.onFileProgress);
            this.resumable.on('filesAdded', this.onFilesAdded);
            this.resumable.on('fileRetry', this.onFileRetry);
            this.resumable.on('fileError', this.onFileError);
            this.resumable.on('uploadStart', this.onUploadStart);
            this.resumable.on('complete', this.onComplete);
            this.resumable.on('progress', this.onProgress);
            this.resumable.on('error', this.onError);
            this.resumable.on('pause', this.onPause);
            this.resumable.on('beforeCancel', this.onBeforeCancel);
            this.resumable.on('cancel', this.onCancel);
            this.resumable.on('chunkingStart', this.onChunkingStart);
            this.resumable.on('chunkingProgress', this.onChunkingProgress);
            this.resumable.on('chunkingComplete', this.onChunkingComplete);
        }
        this.logger.debug('Attached');
    }

    protected handleUploadIcon(count:number)
    {
        this.uploadCount = this.uploadCount + count;
        /**/
        if (this.uploadCount > 0) {
            this.icon.classList.add('animate-ping');
        } else {
            this.icon.classList.remove('animate-ping');
        }
        /**/
    }
    protected onDragEnter = (evt:DragEvent) => {
        evt.preventDefault();
        let el = <HTMLElement>evt.currentTarget;
        let dt = evt.dataTransfer;
        if (dt && dt.types.indexOf('Files') >= 0) {
            evt.stopPropagation();
            dt.dropEffect = 'copy';
            dt.effectAllowed = 'copy';
            el.classList.add('border-green-700');
        } else if (dt) {
            dt.dropEffect = 'none';
            dt.effectAllowed = 'none';
        }
    };
    protected onDragLeave = (evt:Event) => {
        let el = <HTMLElement>evt.currentTarget;
        el.classList.remove('border-green-700');
    };
    protected onFileAdded = (file:Resumable.ResumableFile, event:DragEvent) => {
        this.logger.debug('onFileAdded', file, event);
        this.error = false;
        this.resumable.upload();
    };
    // File upload completed
    protected onFileSuccess = (file:Resumable.ResumableFile, serverMessage:string) => {
        const response = JSON.parse(serverMessage);
        if (this.multiple === false) {
            this.setFile('@blackcubetmp/' + response.finalFilename, file);
        } else {
            this.appendFile('@blackcubetmp/' + response.finalFilename, file);
        }
        this.logger.debug('onFileSuccess', file, serverMessage);
    };
    // File upload progress
    protected onFileProgress = (file:Resumable.ResumableFile, serverMessage:string) => {
        this.logger.debug('onFileProgress', file, serverMessage);
    };
    protected onFilesAdded = (filesAdded:Resumable.ResumableFile[], filesSkipped:Resumable.ResumableFile[]) => {
        this.logger.debug('onFilesAdded', filesAdded, filesSkipped);
    };
    protected onFileRetry = (file:Resumable.ResumableFile) => {
        this.logger.debug('onFileRetry', file);
    };
    protected onFileError = (file:Resumable.ResumableFile, serverMessage:string) => {
        this.logger.debug('onFileError', file, serverMessage);
    };
    protected onUploadStart = () => {
        this.logger.debug('onUploadStart');
        this.handleUploadIcon(1);
    };
    protected onComplete = () => {
        this.logger.debug('onComplete');
        this.handleUploadIcon(-1);
    };
    protected onProgress = () => {
        this.logger.debug('onProgress');
    };
    protected onError = (serverMessage:string, file:Resumable.ResumableFile) => {
        this.logger.debug('onError', file, serverMessage);
    };
    protected onPause = () => {
        this.logger.debug('onPause');
    };
    protected onBeforeCancel = () => {
        this.logger.debug('onBeforeCancel');
    };
    protected onCancel = () => {
        this.logger.debug('onCancel');
        this.handleUploadIcon(-1);
    };
    protected onChunkingStart = (file:Resumable.ResumableFile) => {
        this.logger.debug('onChunkingStart', file);
    };
    protected onChunkingProgress = (file:Resumable.ResumableFile, ratio:number) => {
        this.logger.debug('onChunkingProgressd', file, ratio);
    };
    protected onChunkingComplete = (file:Resumable.ResumableFile) => {
        this.logger.debug('onChunkingComplete', file);
    };

    public get getFiles()
    {
        if (this.resumable.support) {
            return this.resumable.files.map((file:Resumable.ResumableFile, index:number) => {
                return file.fileName;
            });
        }
        return [];
    }

    public detaching()
    {
        if (this.resumable.support) {
            this.drop.removeEventListener('dragover', this.onDragEnter);
            this.drop.removeEventListener('dragenter', this.onDragEnter);
            this.drop.removeEventListener('dragleave', this.onDragLeave);
            this.drop.removeEventListener('drop', this.onDragLeave);
        }

    }

}

