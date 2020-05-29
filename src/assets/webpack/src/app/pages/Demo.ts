/**
 * Demo.ts
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license http://www.redcat.io/license license
 * @version XXX
 * @link http://www.redcat.io
 */
import {Logger} from 'aurelia-logging';
import {DOM, bindable, bindingMode, ComponentAttached, ComponentDetached, inject, LogManager} from 'aurelia-framework';
import EditorJS from '@editorjs/editorjs';
import Header from '@editorjs/header';
import Paragraph from '@editorjs/paragraph';
import Quote from '@editorjs/quote';
import Embed from '@editorjs/embed';
import RawTool from '@editorjs/raw';
import LinkTool from '@editorjs/link';
import List from '@editorjs/list';
import Warning from '@editorjs/warning';
import Delimiter from '@editorjs/delimiter';
import JSONEditor from 'jsoneditor';

import '../../scss/jsoneditor.scss';

/**
 * Application Demo
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license http://www.redcat.io/license license
 * @version XXX
 * @link http://www.redcat.io
 * @since XXX
 */
@inject(DOM.Element)
class Demo implements ComponentAttached, ComponentDetached
{
    public logger:Logger = LogManager.getLogger('pages.Demo');
    private editorJs:EditorJS;
    private jsonSchema:JSONEditor;
    private element:HTMLElement;

    public constructor(element:HTMLElement)
    {
        this.logger.debug('Constructor');
        this.element = element;
    }

    public attached():void
    {
        this.logger.debug('Attached');
        let editor = <HTMLElement>this.element.querySelector('#editor');
        let schema = <HTMLElement>this.element.querySelector('#schema');
        /*/
        this.jsonSchema = new JSONEditor(schema,  {mode: 'tree'});
        this.jsonSchema.set({
            "type": "object",
            "properties": {
            "email": {
                "type": "string",
                    "minLength": 2,
                    "format": "email"
            },
            "telephone": {
                "type": "string",
                    "pattern": "^[0-9]{2}[-.]?[0-9]{2}[-.]?[0-9]{2}[-.]?[0-9]{2}[-.]?[0-9]{2}$",
                    "title": "Téléphone",
                    "description": "Numéro de téléphone au format XX.XX.XX.XX.XX"
            }
        },
            "required":["email"]
        });
        /**/
        this.editorJs = new EditorJS({
            holder: editor,
            minHeight: 50,
            onChange: () => {
                this.logger.debug('Data changed');
            },
            tools: {
                header: {
                    class: Header,
                    // shortcut: 'CMD+SHIFT+H',
                    inlineToolbar : true,
                    config: {
                        placeholder: 'Enter a header',
                        levels: [2, 3, 4],
                        defaultLevel: 2
                    }
                },
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                },
                linkTool: {
                    class: LinkTool,
                    inlineToolbar: true,
                    config: {
                        endpoint: 'http://localhost:8008/fetchUrl', // Your backend endpoint for url data fetching
                    }
                },
                list: {
                    class: List,
                    inlineToolbar: true,
                },
                delimiter: {
                    class: Delimiter,
                    inlineToolbar: true,
                },
                raw: {
                    class: RawTool,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Raw data'
                    }
                },
                warning: {
                    class: Warning,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+W',
                    config: {
                        titlePlaceholder: 'Title',
                        messagePlaceholder: 'Message',
                    },
                },
                embed: {
                    class: Embed,
                    inlineToolbar : true,
                    config: {
                        services: {
                            youtube: true,
                            coub: true,
                            codepen: {
                                regex: /https?:\/\/codepen.io\/([^\/\?\&]*)\/pen\/([^\/\?\&]*)/,
                                embedUrl: 'https://codepen.io/<%= remote_id %>?height=300&theme-id=0&default-tab=css,result&embed-version=2',
                                html: "<iframe height='300' scrolling='no' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'></iframe>",
                                height: 300,
                                width: 600,
                                id: (groups) => groups.join('/embed/')
                            }
                        }
                    }
                },
                // ...
            },
        });
    }

    public detached():void
    {
        this.logger.debug('Detached');
        this.editorJs.destroy();
    }

    public onSave():void
    {
        this.editorJs.save().then((data:any) => {
            this.logger.debug('Saving', data);
        });
    }

}

export { Demo }
