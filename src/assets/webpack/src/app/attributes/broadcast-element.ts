import {customAttribute, INode, IEventAggregator, ILogger, IDisposable, bindable, resolve} from 'aurelia';
import {Broadcast, BroadcastElementEventType} from "../interfaces/broadcast";

@customAttribute('blackcube-broadcast-element')
export class BroadcastElement
{
    @bindable() public event: BroadcastElementEventType;
    @bindable() public events: BroadcastElementEventType[];
    @bindable() public type: string;
    @bindable() public id: string|number;

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('BroadcastElement'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
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