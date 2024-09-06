import {customElement, bindable, IEventAggregator, ILogger, IDisposable, INode, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";
import Quill, {QuillOptionsStatic} from "quill";

const Link = Quill.import('formats/link');
class BlackcubeLink extends Link {
    static create(value: any) {
        let node = super.create(value);
        value = this.sanitize(value);
        node.setAttribute('href', value);
        if(value.startsWith("https://") || value.startsWith("http://") || value.startsWith("://")) {
            // do nothing
        } else {
            node.removeAttribute('target');
        }
        return node;
    }
}
Quill.register(BlackcubeLink, true);

@customElement('blackcube-quill-editor')
export class QuillEditor
{
    @bindable() public fieldId: string;
    @bindable() public fieldName: string;
    @bindable() public content: string = '';
    @bindable() public options: QuillOptionsStatic = {
        theme: 'snow',
        modules: {
            toolbar:[
                ['bold', 'italic', 'underline'],
                [{ 'list': 'bullet' }],
                ['link']
            ]
        },
        formats: ['bold', 'italic', 'link', 'underline', 'list']
    };
    private editorElement:HTMLElement;
    private hiddenField:HTMLInputElement;
    private quill: Quill;
    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('QuillEditor'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private httpService: IHttpService = resolve(IHttpService),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
        this.logger = logger.scopeTo('QuillEditor');
    }

    public attaching()
    {
        this.logger.trace('Attaching');

    }

    public attached()
    {
        if (this.fieldId) {
            this.hiddenField.id = this.fieldId;
        }
        if (this.fieldName) {
            this.hiddenField.name = this.fieldName;
        }
        this.hiddenField.value = this.content;
        this.editorElement.innerHTML = this.content;
        this.options.theme = 'snow';
        this.quill = new Quill(this.editorElement, this.options);
        this.quill.on('text-change', this.onTextChange);
        this.logger.trace('Attached');
    }

    private onTextChange = () => {
        // @ts-ignore
        this.hiddenField.value = this.editorElement.querySelector('.ql-editor')?.innerHTML;
        this.logger.trace(this.editorElement.querySelector('.ql-editor')?.innerHTML);

    };
    public detaching()
    {
        this.quill.off('text-change', this.onTextChange);
        this.logger.trace('Detaching');
    }
}
