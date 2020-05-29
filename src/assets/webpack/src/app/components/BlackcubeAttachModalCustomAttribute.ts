import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from "aurelia-event-aggregator";
import {StorageService} from "../services/StorageService";
import {AjaxService} from "../services/AjaxService";

@inject(DOM.Element, AjaxService)
class BlackcubeAttachModalCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLFormElement;
    @bindable({ primaryProperty: true }) url: string;
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
    private currentForm:HTMLFormElement;
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
        this.element.addEventListener('submit', this.onDelegateSubmit);
    }

    public detached(): void {
        this.element.removeEventListener('submit', this.onDelegateSubmit);
        this.logger.debug('Detached');
    }

    protected onDelegateSubmit = (evt:Event) => {
        if (evt.target) {
            //@ts-ignore
            this.currentForm = <HTMLFormElement>evt.target.closest('form[data-ajax-modal]');
            if (this.currentForm && this.element.contains(this.currentForm)) {
                evt.preventDefault();
                let url = this.currentForm.dataset.ajaxModal;
                if (url) {
                    this.ajaxService.getRequest(url)
                        .then((modal:string) => {
                            this.modalView = modal;
                            this.attachModal();
                        });
                }
            }
        }
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
        this.modal.addEventListener('click', this.onClose);
        this.modalOk.addEventListener('click', this.onSubmitOk);
    }

    protected detachModal() {
        if (this.modalClose) {
            this.modalClose.removeEventListener('click', this.onClose);
        }
        if (this.modalCross) {
            this.modalCross.removeEventListener('click', this.onClose);
        }
        if (this.modalOk) {
            this.modalOk.removeEventListener('click', this.onSubmitOk);
        }
        if (this.modal) {
            this.modal.removeEventListener('click', this.onClose);
            this.modal.remove();
        }
        if (this.backdrop) {
            this.backdrop.remove();
        }
    }
    protected onSubmitOk = (evt:Event) => {
        this.detachModal();
        this.currentForm.submit();

    };
    protected onClose = (evt:Event) => {
        this.detachModal();
    };
    public unbind(): void {
        this.logger.debug('Unbind');
    }
}

export {BlackcubeAttachModalCustomAttribute}
