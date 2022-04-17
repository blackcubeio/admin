import { customAttribute, INode, bindable } from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomElementViewModel, ILifecycleHooks} from "aurelia";

@customAttribute('blackcube-overlay-close')
export class OverlayClose implements ICustomElementViewModel
{

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('OverlayClose');
    }
    public attached()
    {
        this.logger.trace('Attaching');
        this.ea.publish(Overlay.channel, {
            type: OverlayEventType.CLOSE,
        });
    }
}