import {
    customAttribute,
    ICustomAttributeViewModel,
    INode,
    IEventAggregator,
    ILogger,
    IDisposable,
    bindable,
    resolve
} from 'aurelia';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";

@customAttribute('blackcube-overlay-trigger')
export class OverlayTrigger implements ICustomAttributeViewModel
{
    @bindable() title: string;
    @bindable() abstract: string;
    @bindable() url: string;
    @bindable() actionTitle: string;
    @bindable() cancelTitle: string;

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('OverlayTrigger'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attaching()
    {
        this.logger.trace('Attaching');
    }

    public attached()
    {
        this.logger.trace('Attached');
        this.element.addEventListener('click', this.onClick);
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onClick);
    }

    private onClick = (event: Event) => {
        this.logger.debug('onClickOverlay');
        event.preventDefault();
        this.ea.publish(Overlay.channel, {
            type: OverlayEventType.OPEN,
            overlay: {
                title: this.title,
                abstract: this.abstract,
                url: this.url,
                cancelTitle: this.cancelTitle,
                actionTitle: this.actionTitle
            }
        });
    };
}