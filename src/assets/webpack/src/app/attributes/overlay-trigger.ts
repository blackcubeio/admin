import { customAttribute, INode, bindable } from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomAttributeViewModel} from "aurelia";

@customAttribute('blackcube-overlay-trigger')
export class OverlayTrigger implements ICustomAttributeViewModel
{
    @bindable() title: string;
    @bindable() abstract: string;
    @bindable() url: string;
    @bindable() actionTitle: string;
    @bindable() cancelTitle: string;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('OverlayTrigger');
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