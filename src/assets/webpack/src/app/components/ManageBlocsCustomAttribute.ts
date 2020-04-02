
import {DOM, inject, noView, bindable, TemplatingEngine, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, TemplatingEngine, AjaxService)
class ManageBlocsCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    @bindable({ primaryProperty: true }) url: string;
    private logger:Logger = LogManager.getLogger('components.ManageBlocs');
    private templatingEngine:TemplatingEngine;
    private ajaxService:AjaxService;
    private form:HTMLFormElement;
    private ajaxTarget:HTMLElement;

    public constructor(element:HTMLElement, templatingEngine:TemplatingEngine, ajaxService:AjaxService) {
        this.element = element;
        this.templatingEngine = templatingEngine;
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
        this.form = <HTMLFormElement>this.element.closest('form');
        this.ajaxTarget = <HTMLElement>this.element.querySelector('[data-ajax-target]');
        if (this.ajaxTarget === null) {
            this.ajaxTarget = this.element;
        }
        this.element.addEventListener('click', this.onDelegateClick);
    }

    protected onDelegateClick = (evt:Event) => {
        if (evt.target) {
            //@ts-ignore
            let currentButton = <HTMLButtonElement>evt.target.closest('button[type=button]');
            if (currentButton && this.element.contains(currentButton)) {
                this.logger.debug('delegateClick');
                if (currentButton.name) {
                    let formData = new FormData(this.form);
                    formData.append(currentButton.name, currentButton.value);
                    this.ajaxService.getBlocs(this.url, formData)
                        .then(response => {
                            if (response.status == 200) {
                                response.text().then((text:string) => {
                                    this.ajaxTarget.innerHTML = text;
                                    this.templatingEngine.enhance({
                                        element: this.ajaxTarget,
                                        bindingContext: this
                                    })
                                })
                            }
                        });
                }
            }
        }
    };

    public detached(): void {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {ManageBlocsCustomAttribute}
