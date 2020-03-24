
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, AjaxService)
class ManageBlocsCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    @bindable({ primaryProperty: true }) url: string;
    private logger:Logger = LogManager.getLogger('components.ManageBlocs');
    private ajaxService:AjaxService;
    private subButtons:NodeList;
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
        this.logger.debug(this.url);
        this.subButtons = this.element.querySelectorAll('button[type=button]');
        this.subButtons.forEach((button:HTMLButtonElement, key:number, parent:NodeList) => {
            button.addEventListener('click', this.onClick);
        });
        this.form = <HTMLFormElement>this.element.closest('form');
        let formData = new FormData(this.form);
        this.ajaxService.getBlocs(this.url, formData);
    }

    protected onClick = (evt:Event) => {
        this.logger.debug('Click button');
        let button = <HTMLButtonElement>evt.currentTarget;
        if (button.name) {
            let formData = new FormData(this.form);
            formData.append(button.name, '1');
            this.ajaxService.getBlocs(this.url, formData);
        }
    };

    public detached(): void {
        this.logger.debug('Detached');
        this.subButtons.forEach((button:HTMLButtonElement, key:number, parent:NodeList) => {
            button.removeEventListener('click', this.onClick);
        });
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {ManageBlocsCustomAttribute}
