import {
    customAttribute,
    ICustomElementViewModel,
    ILifecycleHooks,
    INode,
    bindable,
    IEventAggregator,
    ILogger,
    IDisposable,
    resolve
} from 'aurelia';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";

@customAttribute('blackcube-overlay-close')
export class OverlayClose implements ICustomElementViewModel
{

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('OverlayClose'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
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