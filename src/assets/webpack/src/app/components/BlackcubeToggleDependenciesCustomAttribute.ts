
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from 'aurelia-event-aggregator';
import {StorageService} from "../services/StorageService";

@inject(DOM.Element)
class BlackcubeToggleDependenciesCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    @bindable({ primaryProperty: true }) targetFilter: string;
    private logger:Logger = LogManager.getLogger('components.ToggleDependencies');
    private toggleTargets:NodeListOf<HTMLElement>;
    private toggleCheckbox:HTMLInputElement|null;

    public constructor(element:HTMLElement) {
        this.element = element;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        if (this.targetFilter.trim() == '') {
            this.targetFilter = '[data-dependency]';
        }
        this.toggleCheckbox = this.element.querySelector('input[type=checkbox]');
        this.toggleTargets = this.element.querySelectorAll(this.targetFilter);
        this.deactivateFields();
        if (this.toggleCheckbox) {
            this.toggleCheckbox.addEventListener('change', this.onChange);
        }
        this.logger.debug('Attached', this.targetFilter);
    }

    public detached(): void {
        if (this.toggleCheckbox) {
            this.toggleCheckbox.removeEventListener('change', this.onChange);
        }
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected activeFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            if(item.classList.contains('opacity-50')) {
                item.classList.remove('opacity-50');
            }
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = false;
            });
        });
    }

    protected deactivateFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            if(!item.classList.contains('opacity-50')) {
                item.classList.add('opacity-50');
            }
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = true;
            });
        });
    }

    protected onChange = (item:Event) => {
        let toggle = <HTMLInputElement>item.currentTarget;
        if (toggle.checked) {
            this.activeFields();
        } else {
            this.deactivateFields();
        }
    }
}

export {BlackcubeToggleDependenciesCustomAttribute}
