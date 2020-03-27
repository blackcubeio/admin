import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from "aurelia-event-aggregator";
import {StorageService} from "../services/StorageService";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, AjaxService)
class AttachModalCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLFormElement;
    @bindable({ primaryProperty: true }) type: string;
    @bindable() id: string;
    private logger:Logger = LogManager.getLogger('components.AttachModal');
    private ajaxService:AjaxService;
    private ready:boolean = false;
    private readyCount:number = 0;
    private modal:HTMLDivElement;
    private backdrop:HTMLDivElement;
    private modalCross:HTMLButtonElement;
    private modalOk:HTMLButtonElement;
    private modalClose:HTMLButtonElement;
    private modalView:string;
    public constructor(element:HTMLFormElement, ajaxService:AjaxService) {
        this.element = element;
        this.logger.debug('Constructor');
        this.ajaxService = ajaxService;
        /*/
        this.ajaxService.getModal()
            .then((modal:string) => {
                this.modalView = modal;
                this.ready= true;
            });

        /**/
    }
    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        this.logger.debug('Attached');
        this.element.addEventListener('submit', this.onSubmit);
    }

    public detached(): void {
        this.element.removeEventListener('submit', this.onSubmit);
        this.logger.debug('Detached');
    }

    protected onSubmit = (evt:Event) => {
        let form = <HTMLFormElement>evt.currentTarget;
        if (this.id && this.type) {
            this.ajaxService.getDetailModal(this.type, this.id)
                .then((modal:string) => {
                    this.modalView = modal;
                    this.attachModal();
                });
        }
        evt.preventDefault();
    };
    protected attachModal() {
        document.body.insertAdjacentHTML('afterbegin', this.modalView);
        this.modal = <HTMLDivElement>document.querySelector('#modal-delete');
        this.backdrop = <HTMLDivElement>document.querySelector('#modal-delete-backdrop');
        this.modalCross = <HTMLButtonElement>this.modal.querySelector('#modal-delete-cross');
        this.modalClose = <HTMLButtonElement>this.modal.querySelector('#modal-delete-close');
        this.modalOk = <HTMLButtonElement>this.modal.querySelector('#modal-delete-ok');
        this.modalClose.addEventListener('click', this.onClose);
        this.modalCross.addEventListener('click', this.onClose);
        this.modalOk.addEventListener('click', this.onSubmitOk);
    }

    protected onSubmitOk = (evt:Event) => {
        if (this.modalCross) {
            this.modalCross.removeEventListener('click', this.onClose);
        }
        if (this.modalClose) {
            this.modalClose.removeEventListener('click', this.onClose);
        }
        if (this.modal) {
            this.modal.remove();
        }
        if (this.backdrop) {
            this.backdrop.remove();
        }
        this.element.submit();

    };
    protected onClose = (evt:Event) => {
        if (this.modalCross) {
            this.modalCross.removeEventListener('click', this.onClose);
        }
        if (this.modalClose) {
            this.modalClose.removeEventListener('click', this.onClose);
        }
        if (this.modal) {
            this.modal.remove();
        }
        if (this.backdrop) {
            this.backdrop.remove();
        }
    };
    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {AttachModalCustomAttribute}
