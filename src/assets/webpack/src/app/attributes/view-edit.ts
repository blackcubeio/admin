import {customAttribute, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {IPlatform, bindable} from "aurelia";
import {HttpService} from "../services/http-service";
import {StorageService} from "../services/StorageService";

@customAttribute('blackcube-view-edit')
export class ViewEdit
{

    private elements: NodeListOf<Element>;
    private toggleButton: HTMLElement;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IPlatform private readonly platform: IPlatform,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('ViewEdit');
    }
    public attaching()
    {
        this.logger.trace('Attaching');
    }

    public attached()
    {
        this.elements = this.element.querySelectorAll('[data-view-edit]');
        this.toggleButton = this.element.querySelector('[data-view-edit=toggle] button');
        this.toggleButton?.addEventListener('click', this.onToggleEvent);
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.toggleButton?.removeEventListener('click', this.onToggleEvent);
    }


    private onToggleEvent = (evt: Event) => {
        this.elements.forEach((element) => {
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        });
    };

}