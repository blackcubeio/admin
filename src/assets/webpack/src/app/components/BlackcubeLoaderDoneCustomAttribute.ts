
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {EventAggregator, Subscription} from 'aurelia-event-aggregator';
import {Logger} from "aurelia-logging";

@inject(DOM.Element, EventAggregator)
class BlackcubeLoaderDoneCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private eventAggregator:EventAggregator;

    private logger:Logger = LogManager.getLogger('components.LoaderDone');

    public constructor(element:HTMLElement, eventAggregator) {
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
        this.logger.debug('Attached');
        this.eventAggregator.publish('RemoveLoader', {});
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onRemoveLoader = (data:any) =>
    {
        this.logger.debug('Remove loader');
        this.element.style.display = 'none';
    }
}

export {BlackcubeLoaderDoneCustomAttribute}
