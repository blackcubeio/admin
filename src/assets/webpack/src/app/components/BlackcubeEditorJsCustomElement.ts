
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import EditorJS, {API} from '@editorjs/editorjs';
import Header from '@editorjs/header';
import RawTool from '@editorjs/raw';
import List from '@editorjs/list';
import Quote from '@editorjs/quote';
import Embed from '@editorjs/embed';
import Marker from '@editorjs/marker';
import Paragraph from '@editorjs/paragraph';
import Delimiter from '@editorjs/delimiter';
import CodeTool from '@editorjs/code';

@inject(DOM.Element)
class BlackcubeEditorJsCustomElement implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.EditorJs');
    private editorJs:EditorJS;
    public editorContent:HTMLDivElement;
    public hiddenField:HTMLInputElement;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fieldId: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fieldName: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fieldValue: string;

    public constructor(element:HTMLElement) {
        this.element = element;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        this.hiddenField.name = this.fieldName;
        this.hiddenField.id = this.fieldId;
        this.hiddenField.value = this.fieldValue;
        this.initEditorJs();
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onEditorJsChange = (api:API) => {
        this.logger.debug('Data changed');
        this.editorJs.save()
            .then((outputData) => {
                let jsonData = JSON.stringify(outputData);
                this.hiddenField.value = jsonData;
        }).catch((error) => {
            this.logger.error('save failed');
        })
    };

    private initEditorJs()
    {
        let initData = {
            blocks: []
        };
        try {
            initData = JSON.parse(this.hiddenField.value);
        } catch (e) {
            this.logger.debug('Data read failed');
        }
        this.editorJs = new EditorJS({
            holder: this.editorContent,
            placeholder: 'Start writing',
            onChange: this.onEditorJsChange,
            minHeight: 50,
            tools: {
                header: {
                    class: Header,
                    config: {
                        placeholder: 'Start to write a header',
                        levels: [1, 2, 3, 4, 5, 6],
                        defaultLevel: 2
                    }
                },
                raw: {
                    class: RawTool,
                    config: {
                        placeholder: 'Start to write HTML code'
                    }
                },
                /*/
                code: {
                    class: CodeTool,
                    config: {
                        placeholder: 'Start coding'
                    }
                },
                /**/
                list: {
                    class: List,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Start to write your list'
                    }
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Start to write a quote',
                        captionPlaceholder: 'Caption'
                    }
                },
                embed: {
                    class: Embed,
                    inlineToolbar: true,
                    config: {
                        services: {
                            youtube: true,
                            vimeo: true
                        }
                    }
                },
                marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M'
                },
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Start to write something'
                    }
                },
                delimiter: {
                    class: Delimiter
                }
            },
            data: initData
        });

    }
}

export {BlackcubeEditorJsCustomElement}
