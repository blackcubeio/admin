
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
        this.form = <HTMLFormElement>this.element.closest('form');
        this.attachEventHandler();
        // let formData = new FormData(this.form);
        // this.ajaxService.getBlocs(this.url, formData);
    }

    protected attachEventHandler() {
        this.subButtons = this.element.querySelectorAll('button[type=button]');
        this.subButtons.forEach((button:HTMLButtonElement, key:number, parent:NodeList) => {
            button.addEventListener('click', this.onClick);
        });
    }

    protected detachEventHandler() {
        this.subButtons.forEach((button:HTMLButtonElement, key:number, parent:NodeList) => {
            button.removeEventListener('click', this.onClick);
        });
    }

    protected onClick = (evt:Event) => {
        let currentTarget = <HTMLElement>evt.currentTarget;
        this.logger.debug('Click button');
        let button = <HTMLButtonElement>currentTarget;
        if (button.name) {
            let formData = new FormData(this.form);
            formData.append(button.name, button.value);
            this.detachEventHandler();
            this.ajaxService.getBlocs(this.url, formData)
                .then(response => {
                    if (response.status == 200) {
                        response.text().then((text:string) => {
                            let target = <HTMLDivElement>this.element.querySelector('.target');
                            if (target) {
                                target.innerHTML = text;
                            } else {
                                this.logger.debug('Error target', text);
                            }
                        })
                    }
                    setTimeout(() => {
                        this.attachEventHandler();
                    }, 0);
                })
                .catch(reason => {
                    this.attachEventHandler();
                })
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
