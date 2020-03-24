
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import JSONEditor from 'jsoneditor';

@inject(DOM.Element)
class SchemaEditorCustomElement implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private jsonEditorElement:HTMLElement|null;
    private logger:Logger = LogManager.getLogger('components.SchemaEditor');
    private jsonSchema:JSONEditor;
    private externalField:HTMLInputElement|null;
    private hiddenField:HTMLInputElement|null;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fieldId: string;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public fieldName: string;
    @bindable({ defaultBindingMode: bindingMode.fromView }) public schema: string;
    @bindable({ defaultBindingMode: bindingMode.fromView }) public language: string;

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
        this.hiddenField = <HTMLInputElement>this.element.querySelector('input[type=hidden]');
        if (this.hiddenField) {
            if (this.fieldId) {
                this.hiddenField.id = this.fieldId;
            }
            if (this.fieldName) {
                this.hiddenField.name = this.fieldName;
            }
            if (this.schema) {
                this.hiddenField.value = this.schema;
            }
        }
        this.jsonEditorElement = this.element.querySelector('div');
        if (this.jsonEditorElement) {
            this.buildEditor();
        }
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    private buildEditor()
    {
        let config:any = {
            mode: "tree",
            search: false,
            navigationBar: false,
            statusBar: false,
            mainMenuBar: false,
            language: "en"
        };
        if (this.language) {
            config.language = this.language;
        }
        if (this.hiddenField) {
            config.onChangeJSON = (jsonData:any) => {
                // @ts-ignore
                this.hiddenField.value = JSON.stringify(jsonData, null, 4);
            };
        }
        this.jsonSchema =new JSONEditor(this.jsonEditorElement,  config);
        this.jsonSchema.setText(this.schema);
        this.jsonSchema.expandAll();

    }

}

export {SchemaEditorCustomElement}
