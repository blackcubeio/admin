import {customAttribute, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {IPlatform, bindable} from "aurelia";
import {HttpService} from "../services/http-service";
import {StorageService} from "../services/StorageService";

@customAttribute('blackcube-fold')
export class Fold
{
    private targetElement: HTMLElement|null;
    private openElement: HTMLElement|null;
    private closeElement: HTMLElement|null;
    @bindable() elementId: string;
    @bindable() elementType: string;
    @bindable() elementSubData: string;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IPlatform private readonly platform: IPlatform,
        private readonly httpService: HttpService,
        private readonly storageService: StorageService,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('Fold');
    }
    public attaching()
    {
        this.logger.trace('Attaching');
    }

    public attached()
    {
        this.targetElement = this.element.querySelector('[data-target-fold]');
        this.openElement = this.element.querySelector('[data-fold=down]');
        this.closeElement = this.element.querySelector('[data-fold=up]');
        this.element.addEventListener('click', this.onDelegateEvent);
        this.logger.trace('Attached');
        const isOpened = this.storageService.getElementOpened(this.elementType, this.elementSubData, this.elementId);
        if (isOpened) {
            this.openElement?.classList.remove('hidden');
            this.closeElement?.classList.add('hidden');
            this.targetElement?.classList.remove('hidden');
        } else {
            this.openElement?.classList.add('hidden');
            this.closeElement?.classList.remove('hidden');
            this.targetElement?.classList.add('hidden');
        }
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }

    private toggle()
    {
        if (this.targetElement?.classList.contains('hidden')) {
            this.openElement?.classList.remove('hidden');
            this.closeElement?.classList.add('hidden');
            this.targetElement?.classList.remove('hidden');
            this.storageService.setElementOpened(this.elementType, this.elementSubData, this.elementId);
        } else {

            this.openElement?.classList.add('hidden');
            this.closeElement?.classList.remove('hidden');
            this.targetElement?.classList.add('hidden');
            this.storageService.setElementClosed(this.elementType, this.elementSubData, this.elementId);
        }
    }

    private onDelegateEvent = (evt: Event) => {
        if (evt.target) {
            const el = <HTMLElement>evt.target;
            const triggerElement = <HTMLElement>el.closest('[data-fold]');
            if (triggerElement) {
                const mode = triggerElement.dataset.fold;
                evt.preventDefault();
                evt.stopPropagation();
                this.toggle();
            }
        }

    };

}