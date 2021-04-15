
import {DOM, inject, noView, bindable, bindingMode, TemplatingEngine, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";

enum AjaxEvent {
    CLICK = 'click',
    DBLCLICK = 'dblclick',
    INPUT = 'input',
    CHANGE = 'change',
    SUBMIT = 'submit',
    BLUR = 'blur',
    FOCUS = 'focus',
}

@inject(DOM.Element, AjaxService)
class BlackcubeUrlGeneratorCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.BlackcubeUrlGenerator');
    private ajaxService:AjaxService;
    @bindable({ primaryProperty: true }) urlGenerator: string;

    private form:HTMLFormElement;

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

    public attached(): void {
        this.logger.debug('Attached');
        this.element.addEventListener('click', this.onClick);
    }

    protected onClick = (event:Event) => {
        event.preventDefault();
        const data = this.getUrlGeneratorData();
        this.ajaxService.postRequestJson(this.urlGenerator, data)
            .then((response:any) => {
                const slugPath = DOM.querySelector('[name="Slug[path]"]') as HTMLInputElement;
                this.logger.debug('Received : ', response, response.url);
                if (slugPath) {
                    slugPath.value = response.url;
                }
            })
            .catch((error:any) => {
                this.logger.warn('Error while submitting URL', error);
            })
    };

    public detached(): void {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onClick);
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    private getUrlGeneratorData()
    {
        let elementSelect = DOM.querySelector('[name="NodeComposite[nodeId]"]');
        let parentElementType:string|null = null;
        let parentElementId:string|null = null;
        let name:string|null = '---';
        //@ts-ignore
        if (elementSelect && elementSelect.selectedOptions.length === 1) {
            //@ts-ignore
            const nodeId = elementSelect.selectedOptions[0].value;
            const compositeName = DOM.querySelector('[name="Composite[name]"]') as HTMLInputElement;
            if (compositeName) {
                name = compositeName.value;
            }
            parentElementType = 'node';
            parentElementId = nodeId;
        } else {
            elementSelect = DOM.querySelector('[name="parentNodeId"]');
            if (elementSelect) {
                //@ts-ignore
                const nodeId = elementSelect.value;
                parentElementType = 'node';
                parentElementId = nodeId;
                const nodeName = DOM.querySelector('[name="Node[name]"]') as HTMLInputElement;
                if (nodeName) {
                    name = nodeName.value;
                }
            } else {
                elementSelect = DOM.querySelector('[name="moveNodeTarget"]');
                if (elementSelect) {
                    //@ts-ignore
                    const nodeId = elementSelect.value;
                    parentElementType = 'node';
                    parentElementId = nodeId;
                    const nodeName = DOM.querySelector('[name="Node[name]"]') as HTMLInputElement;
                    if (nodeName) {
                        name = nodeName.value;
                    }
                } else {

                    elementSelect = DOM.querySelector('[name="Tag[categoryId]"]');
                    //@ts-ignore
                    if (elementSelect && elementSelect.selectedOptions.length === 1) {
                        //@ts-ignore
                        const categoryId = elementSelect.selectedOptions[0].value;
                        parentElementType = 'category';
                        parentElementId = categoryId;
                        const tagName = DOM.querySelector('[name="Tag[name]"]') as HTMLInputElement;
                        if (tagName) {
                            name = tagName.value;
                        }
                    } else {
                        const categoryName = DOM.querySelector('[name="Category[name]"]') as HTMLInputElement;
                        if (categoryName) {
                            name = categoryName.value;
                        }
                    }
                }
            }
        }
        return {
            name,
            parentElementType,
            parentElementId
        };
    }
}

export {BlackcubeUrlGeneratorCustomAttribute}
