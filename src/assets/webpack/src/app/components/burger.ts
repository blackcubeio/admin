import {customElement, bindable, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { AlertEvent, AlertEventType, AlertStatus, AlertType } from '../interfaces/alert';
import { transitionWithPromise } from '../helpers/transition';
import {Menu} from "../attributes";
import {MenuEventType} from "../interfaces/menu";
import {containerless, ICustomElementViewModel} from "aurelia";


@customElement('blackcube-burger')
@containerless()
export class Burger implements ICustomElementViewModel
{
    private openMenuBtn: HTMLButtonElement;
    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Burger');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        this.openMenuBtn.addEventListener('click', this.onClick);

    }

    private onClick = (event: Event) => {
        // this.stackedAlerts.push(event);
        event.preventDefault();
        this.ea.publish(Menu.channel, {type: MenuEventType.OPEN});

    };

    public attached()
    {
        this.logger.trace('Attached');
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.openMenuBtn.removeEventListener('click', this.onClick);
    }


}