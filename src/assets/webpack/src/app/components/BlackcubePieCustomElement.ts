
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import * as Chartist from 'chartist';

@noView()
@inject(DOM.Element)
class BlackcubePieCustomElement implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private logger:Logger = LogManager.getLogger('components.ChartistPie');
    private chart:Chartist;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public inactive: number = 0;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public activeUrl: number = 0;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public activeNoUrl: number = 0;
    @bindable({ defaultBindingMode: bindingMode.fromView}) public inactiveLabel: string = 'Inactive';
    @bindable({ defaultBindingMode: bindingMode.fromView}) public activeUrlLabel: string = 'Active';
    @bindable({ defaultBindingMode: bindingMode.fromView}) public activeNoUrlLabel: string = 'Active No URL';
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
        this.chart = new Chartist.Pie(this.element, {
            labels: [this.activeUrlLabel, this.inactiveLabel, this.activeNoUrlLabel],
            series: [{
                value: this.activeUrl,
                name: this.activeUrlLabel,
                className: 'active-url',
                meta: 'Meta One'
            }, {
                value: this.inactive,
                name: this.inactiveLabel,
                className: 'inactive',
                meta: 'Meta Two'
            }, {
                value: this.activeNoUrl,
                name: this.activeNoUrlLabel,
                className: 'active-no-url',
                meta: 'Meta Three'
            }]
        }, {
            width: '220px',
            height: '220px',
            donut: true,
            labelOffset: -50,
            donutWidth: 25,
            donutSolid: true,
            startAngle: 270,
            showLabel: true,
            ignoreEmptyValues: true
            // labelPosition: 'outside'
        });
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubePieCustomElement}
