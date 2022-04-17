import { customAttribute, INode, bindable } from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomElementViewModel, ILifecycleHooks} from "aurelia";
import {Broadcast, BroadcastElementEventType} from "../interfaces/broadcast";

@customAttribute('blackcube-toggle-dependencies')
export class ToggleDependencies
{
    public target: string = 'data-dependency';
    public source: string = 'data-dependency-source'
    private toggleElement :HTMLInputElement|null;
    private toggleTargets: NodeListOf<HTMLElement>;
    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('ToggleDependencies');
    }
    public attached()
    {
        this.toggleElement = this.element.querySelector('['+this.source+']');
        if (this.toggleElement) {
            this.toggleTargets = this.element.querySelectorAll('['+this.target+']');
            if (this.toggleElement.checked) {
                this.activateFields();
            } else {
                this.deactivateFields();
            }
            this.toggleElement.addEventListener('change', this.onChange);
        }
    }

    public detaching(): void {
        if (this.toggleElement) {
            this.toggleElement.removeEventListener('change', this.onChange);
        }
    }

    protected onChange = (item:Event) => {
        let toggle = <HTMLInputElement>item.currentTarget;
        if (toggle.checked) {
            this.activateFields();
        } else {
            this.deactivateFields();
        }
    }

    protected activateFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            item.classList.remove('opacity-50');
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = false;
            });
        });
    }
    protected deactivateFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            item.classList.add('opacity-50');
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = true;
            });
        });
    }
}