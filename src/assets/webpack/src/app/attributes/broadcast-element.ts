import { customAttribute, INode, bindable } from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomElementViewModel, ILifecycleHooks} from "aurelia";
import {Broadcast, BroadcastElementEventType} from "../interfaces/broadcast";

@customAttribute('blackcube-broadcast-element')
export class BroadcastElement
{
    @bindable() public event: BroadcastElementEventType;
    @bindable() public events: BroadcastElementEventType[];
    @bindable() public type: string;
    @bindable() public id: string|number;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('BroadcastElement');
    }
    public attached()
    {
        this.logger.trace('Attaching');
        if (this.event) {
            this.ea.publish(Broadcast.channel, {
                type: this.event,
                data : {
                    type: this.type,
                    id: this.id
                }
            });
        } else if (this.events) {
            this.events.forEach((event) => {
                this.ea.publish(Broadcast.channel, {
                    type: event,
                    data : {
                        type: this.type,
                        id: this.id
                    }
                });
            });

        }

    }
}