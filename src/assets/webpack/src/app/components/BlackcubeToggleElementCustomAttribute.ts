
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from 'aurelia-event-aggregator';
import {StorageService} from "../services/StorageService";

@inject(DOM.Element, StorageService)
class BlackcubeToggleElementCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    @bindable() elementId: string;
    @bindable() elementType: string;
    @bindable() elementSubData: string;
    private storageService:StorageService;
    private logger:Logger = LogManager.getLogger('components.BlackcubeToggleData');
    private showHideTargets:NodeListOf<HTMLElement>;


    public constructor(element:HTMLElement, storageService:StorageService) {
        this.element = element;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        this.logger.debug('Current ID', this.elementId);
        //TODO: should delegate
        let opened = this.storageService.getElementOpened(this.elementType, this.elementSubData, this.elementId);
        let currentButton = <HTMLElement>this.element.querySelector('[data-toggle-element=source]');
        this.showHideTargets = this.element.querySelectorAll('[data-toggle-element=target]');
        if (opened) {
            this.showTargets(currentButton);
            // this.titleBloc.addEventListener('click', this.onToggle);
        } else {
            this.hideTargets(currentButton);
        }
        this.element.addEventListener('click', this.onDelegateClick);
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onDelegateClick = (evt:Event) => {
        if (evt.target) {
            //@ts-ignore
            let currentButton = <HTMLElement>evt.target.closest('[data-toggle-element=source]');
            if (currentButton && this.element.contains(currentButton)) {
                this.logger.debug('delegateClick');
                let open = this.storageService.getElementOpened(this.elementType, this.elementSubData, this.elementId);
                if (open) {
                    this.hideTargets(currentButton);
                    this.storageService.setElementClosed(this.elementType, this.elementSubData, this.elementId);
                } else {
                    this.showTargets(currentButton);
                    this.storageService.setElementOpened(this.elementType, this.elementSubData, this.elementId);
                }
            }
        }
    };

    protected showTargets(button:HTMLElement)
    {
        this.showHideTargets.forEach((item:HTMLElement) => {
            if (item.classList.contains('hidden')) {
                item.classList.remove('hidden');
            }
        });
        if (button) {
            let icon = <HTMLElement>button.querySelector('.fa');
            if (icon) {
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        }
    }
    protected hideTargets(button:HTMLElement)
    {
        this.showHideTargets.forEach((item:HTMLElement) => {
            if (!item.classList.contains('hidden')) {
                item.classList.add('hidden');
            }
        })
        if (button) {
            let icon = <HTMLElement>button.querySelector('.fa');
            if (icon) {
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }
    }
}

export {BlackcubeToggleElementCustomAttribute}
