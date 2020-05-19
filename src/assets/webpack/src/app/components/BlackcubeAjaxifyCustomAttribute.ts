
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

@inject(DOM.Element, TemplatingEngine, AjaxService)
class BlackcubeAjaxifyCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.BlackcubeAjaxify');
    private ajaxService:AjaxService;
    private templatingEngine:TemplatingEngine;

    @bindable({ primaryProperty: true }) event: AjaxEvent;
    // data-ajaxify-source="event-name" // which element should be monitored
    // data-ajaxify-target="event-name" // where we replace the HTML
    // target url should be set in target[data-ajaxify-url="url"]

    private form:HTMLFormElement;

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
        this.element.addEventListener(this.event, this.onDelegateEvent);
    }

    protected onDelegateEvent = (event:Event) => {
        if (event.target) {
            //@ts-ignore
            let triggerElement = <HTMLElement>event.target.closest('[data-ajaxify-source]');
            if (triggerElement && this.element.contains(triggerElement)) {
                // if we have triggerElement and triggerElement should be handled
                let currentSource = triggerElement.dataset.ajaxifySource;
                let targetSelector:string|null = null;
                let targetUrl:string|null = null;
                let targetElement:HTMLElement|null = null;
                if (currentSource) {
                    targetSelector = '[data-ajaxify-target=' + currentSource +']';
                }
                if (targetSelector !== null) {
                    targetElement = <HTMLElement>this.element.querySelector(targetSelector);
                    if (!targetElement && this.element.dataset.ajaxifyTarget === currentSource) {
                        targetElement = this.element;
                    }
                }
                if (this.event === AjaxEvent.SUBMIT) {
                    // we should handle the form (post / ...)
                    let elementForm = <HTMLFormElement>triggerElement.closest('form');
                    if (elementForm) {
                        if (elementForm.method.toLowerCase() === 'post') {
                            let formData = new FormData(elementForm);
                            if (triggerElement.hasAttribute('name') && triggerElement.hasAttribute('value')) {
                                //@ts-ignore
                                formData.append(triggerElement.name, triggerElement.value);
                            }
                            event.preventDefault();
                            this.ajaxService.postRequest(elementForm.action, formData)
                                .then((html:string) => {
                                    //@ts-ignore
                                    targetElement.innerHTML = html;
                                    let isAlreadyEnhanced = this.element.isSameNode(targetElement);
                                    //TODO: should probably enhance children
                                    if (isAlreadyEnhanced === false) {
                                        /**/
                                        this.templatingEngine.enhance({
                                            //@ts-ignore
                                            element:targetElement,
                                            bindingContext: this
                                        });
                                        /**/
                                    }
                                })
                                .catch((error:any) => {
                                    this.logger.warn('Error while submitting URL', error);
                                })
                        } else {
                            this.logger.warn('Unhandled form method : ', elementForm.method);
                        }
                    }
                    // we should attach modal if needed
                } else {
                    if (triggerElement && triggerElement.dataset.ajaxifyUrl) {
                        targetUrl = triggerElement.dataset.ajaxifyUrl;
                        //@ts-ignore
                    } else if (triggerElement && triggerElement.href) {
                        //@ts-ignore
                        targetUrl = triggerElement.href;
                    }
                    if(targetUrl !== null) {
                        event.preventDefault();
                        this.ajaxService.getRequest(targetUrl)
                            .then((html:string) => {
                                //@ts-ignore
                                targetElement.innerHTML = html;
                                let isAlreadyEnhanced = this.element.isSameNode(targetElement);
                                //TODO: should probably enhance children
                                if (isAlreadyEnhanced === false) {
                                    /**/
                                    this.templatingEngine.enhance({
                                        //@ts-ignore
                                        element:targetElement,
                                        bindingContext: this
                                    });
                                    /**/
                                }
                            })
                            .catch((error:any) => {
                                this.logger.warn('Error while requesting URL', error);
                            });
                    }
                    // we should handle a regular request
                }
            }
        }
    };

    public detached(): void {
        this.logger.debug('Detached');
        this.element.removeEventListener(this.event, this.onDelegateEvent);
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubeAjaxifyCustomAttribute}
