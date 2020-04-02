
import {DOM, inject, noView, bindable, bindingMode, TemplatingEngine, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, TemplatingEngine, AjaxService)
class AjaxLinkManagerCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.AjaxLinkManager');
    private ajaxService:AjaxService;
    private templatingEngine:TemplatingEngine;
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
        this.element.addEventListener('click', this.onDelegateClick);
    }

    protected onDelegateClick = (evt:Event) => {
        if (evt.target) {
            //@ts-ignore
            let currentLink = <HTMLLinkElement>evt.target.closest('a[data-ajax]');
            if (currentLink && this.element.contains(currentLink)) {
                evt.preventDefault();
                this.logger.debug('delegateClick');
                let url = currentLink.href;
                this.ajaxService.getRequest(url)
                    .then((html:string) => {
                        this.element.innerHTML = html;
                        /*/
                        this.templatingEngine.enhance({
                            element:this.element,
                            bindingContext: this
                        })
                        /*/
                    });
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

export {AjaxLinkManagerCustomAttribute}
