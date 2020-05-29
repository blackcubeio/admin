
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from 'aurelia-event-aggregator';
import {StorageService} from "../services/StorageService";

@inject(DOM.Element, EventAggregator, StorageService)
class BlackcubeToggleSlugCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    @bindable({ primaryProperty: true }) elementId: string;
    private eventAggregator:EventAggregator;
    private storageService:StorageService;
    private logger:Logger = LogManager.getLogger('components.ToggleSlug');
    private toggleCheckbox:HTMLInputElement|null;
    private toggleBloc:HTMLElement|null;
    private toggleBlocInitialDisplay:string = 'inherit';
    private titleBloc:HTMLElement|null;
    private currentStatusInput:HTMLInputElement|null;

    public constructor(element:HTMLElement, eventAggregator:EventAggregator, storageService:StorageService) {
        this.element = element;
        this.eventAggregator = eventAggregator;
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
        let opened = this.storageService.getElementSlugOpened(this.elementId);
        this.toggleCheckbox = this.element.querySelector('.toggle');
        this.toggleBloc = this.element.querySelector('.toggle-target');
        this.titleBloc = <HTMLElement>this.element.firstElementChild;
        if (this.toggleBloc) {
            this.toggleBlocInitialDisplay = this.toggleBloc.style.display;
            if (this.elementId === '' && this.toggleCheckbox) {
                opened = this.toggleCheckbox.checked;
            }
            if (opened === false) {
                this.toggleBloc.classList.add('hidden');
            } else {
                this.toggleBloc.classList.remove('hidden');
            }
        }
        if (this.toggleCheckbox) {
            this.toggleCheckbox.addEventListener('change', this.onChange);
        }
        if (this.titleBloc && this.toggleBloc) {
            this.titleBloc.addEventListener('click', this.onToggle);
        }
        this.eventAggregator.publish('RemoveLoader', {});
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
    protected onToggle = () => {
        if (this.toggleBloc && this.toggleCheckbox && this.toggleCheckbox.checked) {
            if (this.toggleBloc.classList.contains('hidden')) {
                this.toggleBloc.classList.remove('hidden');
                if (this.titleBloc) {
                    let icon = <HTMLElement>this.titleBloc.querySelector('.fa');
                    if (icon) {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }

                this.storageService.setElementSlugOpened(this.elementId);
            } else {
                this.toggleBloc.classList.add('hidden');
                if (this.titleBloc) {
                    let icon = <HTMLElement>this.titleBloc.querySelector('.fa');
                    if (icon) {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                }
                this.storageService.setElementSlugClosed(this.elementId);
            }
        }
    };

    protected onChange = () => {
        if (this.toggleBloc && this.toggleCheckbox) {
            if (this.toggleCheckbox.checked) {
                this.toggleBloc.classList.remove('hidden');
                if (this.titleBloc) {
                    let icon = <HTMLElement>this.titleBloc.querySelector('.fa');
                    if (icon) {
                        icon.classList.remove('fa-chevron-down');
                        icon.classList.add('fa-chevron-up');
                    }
                }
                this.storageService.setElementSlugOpened(this.elementId);
            } else {
                this.toggleBloc.classList.add('hidden');
                if (this.titleBloc) {
                    let icon = <HTMLElement>this.titleBloc.querySelector('.fa');
                    if (icon) {
                        icon.classList.remove('fa-chevron-up');
                        icon.classList.add('fa-chevron-down');
                    }
                }
                this.storageService.setElementSlugClosed(this.elementId);
            }
        }
    }
}

export {BlackcubeToggleSlugCustomAttribute}
