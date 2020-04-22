
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import JSONEditor from 'jsoneditor';
import {AjaxService} from '../services/AjaxService';

interface Composite {
    id:number,
    name:string
}
@inject(DOM.Element, AjaxService)
class BlackcubeSearchCompositeCustomElement implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    public search:HTMLInputElement;
    public compositeAdd:HTMLButtonElement;
    private logger:Logger = LogManager.getLogger('components.SearchComposite');
    @bindable({ defaultBindingMode: bindingMode.fromView }) public searchUrl: string;
    private ajaxService:AjaxService;
    public composites:Composite[] = [];


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
        this.search.addEventListener('focus', this.onInput);
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.search.removeEventListener('focus', this.onInput);
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onClick()
    {
        this.logger.debug('Submit sent');
        this.search.value = '';
    }

    protected buildSearchQuery(search:string)
    {
        return this.searchUrl.replace('__query__', search);
    }

    protected onChoose(id:number, value:string)
    {
        //@ts-ignore
        this.compositeAdd.value = id;
        this.search.value = value;
        this.composites = [];
    }
    protected onInput = (event:Event) =>
    {
        this.compositeAdd.value = '';
        // if (this.search.value.trim() === '') {
            // this.composites = [];
        // } else {
            this.ajaxService.getRequestJson(this.buildSearchQuery(this.search.value))
                .then((composites:Composite[]) => {
                    this.composites = composites;
                    /*/
                    if (composites.length === 1) {
                        this.onChoose(composites[0].id, composites[0].name);
                    }
                    /**/
                });
        // }
    }

}

export {BlackcubeSearchCompositeCustomElement}
