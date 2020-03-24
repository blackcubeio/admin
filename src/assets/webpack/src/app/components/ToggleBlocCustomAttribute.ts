
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from 'aurelia-event-aggregator';

@inject(DOM.Element, EventAggregator)
class ToggleBlocCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private eventAggregator:EventAggregator;
    private logger:Logger = LogManager.getLogger('components.ToggleBloc');
    private toggleCheckbox:HTMLInputElement|null;
    private toggleBloc:HTMLElement|null;
    private toggleBlocInitialDisplay:string = 'inherit';
    private titleBloc:HTMLElement|null;

    public constructor(element:HTMLElement, eventAggregator:EventAggregator) {
        this.element = element;
        this.eventAggregator = eventAggregator;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        this.toggleCheckbox = this.element.querySelector('.toggle');
        this.toggleBloc = this.element.querySelector('.toggle-target');
        this.titleBloc = <HTMLElement>this.element.firstElementChild;
        if (this.toggleBloc) {
            this.toggleBlocInitialDisplay = this.toggleBloc.style.display;
            this.toggleBloc.style.display = 'none';
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
        if (this.toggleBloc) {
            if (this.toggleBloc.style.display === 'none') {
                this.toggleBloc.style.display = this.toggleBlocInitialDisplay;
            } else {
                this.toggleBloc.style.display = 'none';
            }
        }
    }
    protected onChange = () => {
        if (this.toggleBloc && this.toggleCheckbox) {
            if (this.toggleCheckbox.checked) {
                this.toggleBloc.style.display = this.toggleBlocInitialDisplay;
            } else {
                this.toggleBloc.style.display = 'none';
            }
        }
    }
}

export {ToggleBlocCustomAttribute}
