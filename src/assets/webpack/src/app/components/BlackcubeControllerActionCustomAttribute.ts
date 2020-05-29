
import {DOM, inject, noView, bindable, bindingMode, TemplatingEngine, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, AjaxService)
class BlackcubeControllerActionCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.BlackcubeControllerAction');
    @bindable({ primaryProperty: true }) public url: string;
    private sourceElement:HTMLSelectElement;
    private targetElement:HTMLSelectElement;
    private ajaxService:AjaxService;
    private originalSourceValue:string;
    private originalTargetValue:string;

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
        this.sourceElement = <HTMLSelectElement>this.element.querySelector('[data-controller-action=source]');
        this.originalSourceValue = this.sourceElement.value;
        this.targetElement = <HTMLSelectElement>this.element.querySelector('[data-controller-action=target]');
        this.originalTargetValue = this.targetElement.value;
        this.sourceElement.addEventListener('change', this.onChange);
        this.logger.debug('Attached');
    }

    protected onChange = (evt:Event) => {
        let select = <HTMLSelectElement>evt.currentTarget;
        let url = this.url.replace('__controller__', select.value);
        this.ajaxService.getRequestJson(url)
            .then((body:any[]) => {
               this.logger.debug('body');
               let length = this.targetElement.options.length;
               for (let i=(length - 1); i >= 0; i--) {
                   this.targetElement.options[i].remove();
               }
               body.forEach((value:any) => {
                   let option = <HTMLOptionElement>document.createElement('option');
                   option.value = value.id;
                   option.label = value.name;
                   if ((select.value === this.originalSourceValue) && (option.value === this.originalTargetValue)) {
                       option.selected = true;
                   }
                   this.targetElement.options.add(option);
               })
            });

        this.logger.debug('onChange', select.value);
    };
    public detached(): void {
        this.sourceElement.removeEventListener('change', this.onChange);
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubeControllerActionCustomAttribute}
