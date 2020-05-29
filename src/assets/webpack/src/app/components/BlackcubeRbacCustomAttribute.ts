
import {DOM, inject, noView, bindable, bindingMode, TemplatingEngine, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService, Csrf} from "../services/AjaxService";

@inject(DOM.Element, AjaxService)
class BlackcubeRbacCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.BlackcubeRbac');
    @bindable({ primaryProperty: true }) targetUrl: string;
    private ajaxService:AjaxService;
    private csrf:Csrf;

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
        let parentForm = <HTMLFormElement>this.element.closest('form');
        let csrfField = <HTMLInputElement>parentForm.querySelector('input[name=_csrf]');
        this.csrf = {
            name: csrfField.name,
            value: csrfField.value
        };
        this.element.addEventListener('change', this.onDelegateChange);
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.element.removeEventListener('change', this.onDelegateChange);
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onDelegateChange = (event:Event) => {
        if (event.target) {
            //@ts-ignore
            let currentCheckbox = <HTMLInputElement>event.target.closest('input[type=checkbox]');
            if (currentCheckbox && this.element.contains(currentCheckbox)) {
                this.logger.debug('delegateClick', currentCheckbox.dataset);
                let formData = new FormData();
                if ('rbacType' in currentCheckbox.dataset) {
                    //@ts-ignore
                    formData.append('type', currentCheckbox.dataset.rbacType);
                }
                if ('rbacName' in currentCheckbox.dataset) {
                    //@ts-ignore
                    formData.append('name', currentCheckbox.dataset.rbacName);
                }
                formData.append('mode', currentCheckbox.checked ? 'add' : 'remove');
                formData.append(this.csrf.name, this.csrf.value);
                // formData.append()
                this.ajaxService.updateRbac(this.targetUrl, formData)
                    .then((response:Response) => {
                        return response.text();
                    })
                    .then((html:string) => {
                        this.element.innerHTML = html;
                    });

            }
        }

    };
}

export {BlackcubeRbacCustomAttribute}
