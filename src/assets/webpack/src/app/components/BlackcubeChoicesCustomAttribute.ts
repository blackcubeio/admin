import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from "aurelia-event-aggregator";
import {StorageService} from "../services/StorageService";
import {AjaxService} from "../services/AjaxService";
import Choices from "choices.js";

@inject(DOM.Element, AjaxService)
class BlackcubeChoicesCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLFormElement;
    // @bindable({ primaryProperty: true }) url: string;
    private logger:Logger = LogManager.getLogger('components.ChoicesManager');
    private ajaxService:AjaxService;
    private choices:Choices;

    public constructor(element:HTMLFormElement, ajaxService:AjaxService) {
        this.element = element;
        this.logger.debug('Constructor');
        this.ajaxService = ajaxService;
    }
    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        this.logger.debug('Attached');
        // @ts-ignore
        this.choices = new Choices(this.element, {
            removeItemButton: true,
            searchFields: ['label']
        });
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubeChoicesCustomAttribute}
