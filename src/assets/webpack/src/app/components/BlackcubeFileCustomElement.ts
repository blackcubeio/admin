
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";
import Resumable from "resumablejs"
import URI from 'urijs';

interface UploadedFile {
    name:string,
    shortname:string|undefined,
    previewUrl:string,
    deleteUrl:string,
    file?:Resumable.ResumableFile|null
}
interface Csrf {
    name:string,
    value:string
}
@inject(DOM.Element, AjaxService)
class BlackcubeFileCustomElement implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.BlackcubeFile');
    private resumable:Resumable;
    public browseButton:HTMLButtonElement;
    public dropTarget:HTMLElement;
    private parentForm:HTMLFormElement;
    public hiddenField:HTMLInputElement;
    private handledFiles:UploadedFile[];
    private ajaxService:AjaxService;
    private csfr:Csrf;


    @bindable({ defaultBindingMode: bindingMode.fromView}) public uploadUrl: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public previewUrl: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public deleteUrl: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fileType: string = '';
    @bindable({ defaultBindingMode: bindingMode.fromView}) public name: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public multiple: string|boolean = false;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public value: string = '';
    @bindable({ defaultBindingMode: bindingMode.fromView}) public imageWidth: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public imageHeight: string;

    public constructor(element:HTMLElement, ajaxService:AjaxService) {
        this.element = element;
        this.ajaxService = ajaxService;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
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
            this.ajaxService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
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

    public onRemove = (handledFile:UploadedFile) =>
    {
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
            this.ajaxService.deleteRequest(handledFile.deleteUrl, this.csfr.value);
            // should call WS delete
        }
        let fieldValue = this.getFilesValue();
        this.hiddenField.value = fieldValue;

    };

    public attached(): void {
        this.parentForm = <HTMLFormElement>this.element.closest('form');
        this.logger.debug('Multiple', this.multiple);
        let resumableConfig:Resumable.ConfigurationHash = {
            target: this.uploadUrl
        };
        let fileTypes = this.fileType.split(/\s*,\s*/).filter((value:string, index:number) => {
            return value.trim() !== '';
        });
        resumableConfig.fileType = fileTypes;
        if (this.parentForm) {
            let csrfField = <HTMLInputElement>this.parentForm.querySelector('input[name=_csrf]');
            this.csfr = {
                name: csrfField.name,
                value: csrfField.value
            };
            resumableConfig.query = {};
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
            this.logger.debug('Resume js supported', this.browseButton);
            this.resumable.assignBrowse(this.browseButton, false);
            this.resumable.assignDrop(this.browseButton);
            this.browseButton.addEventListener('dragover', this.onDragEnter);
            this.browseButton.addEventListener('dragenter', this.onDragEnter);
            this.browseButton.addEventListener('dragleave', this.onDragLeave);
            this.browseButton.addEventListener('drop', this.onDragLeave);
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

    protected onDragEnter = (evt:DragEvent) => {
        evt.preventDefault();
        let el = <HTMLElement>evt.currentTarget;
        let dt = evt.dataTransfer;
        if (dt && dt.types.indexOf('Files') >= 0) {
            evt.stopPropagation();
            dt.dropEffect = 'copy';
            dt.effectAllowed = 'copy';
            el.classList.add('dragover');
        } else if (dt) {
            dt.dropEffect = 'none';
            dt.effectAllowed = 'none';
        }
    };
    protected onDragLeave = (evt:Event) => {
        let el = <HTMLElement>evt.currentTarget;
        el.classList.remove('dragover');
    };
    protected onFileAdded = (file:Resumable.ResumableFile, event:DragEvent) => {
        this.logger.debug('onFileAdded', file, event);
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
    };
    protected onComplete = () => {
        this.logger.debug('onComplete');
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

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubeFileCustomElement}
