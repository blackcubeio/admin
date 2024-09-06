import {
    ICustomAttributeViewModel,
    IPlatform,
    bindable,
    customAttribute,
    INode,
    IEventAggregator,
    ILogger,
    resolve
} from "aurelia";
import {NotificationCenter, Overlay} from '../components';
import {NotificationCenterEventType, NotificationType} from '../interfaces/notification';
import {OverlayEventType} from "../interfaces/overlay";

// @customAttribute({name: 'blackcube-notification-trigger', aliases:['bc-nt']})
@customAttribute('blackcube-notification-trigger')
export class NotificationTrigger implements ICustomAttributeViewModel
{
    @bindable() public title: string = '';
    @bindable() public type: NotificationType = NotificationType.CHECK;
    @bindable() public content: string = '';
    @bindable() public duration: number = 5000;
    @bindable() public closeOverlay: boolean = false;

    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('NotificationTrigger'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
        this.logger.trace('constructor');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
    }
    public attached()
    {
        this.logger.trace('Send Notification');
        this.platform.taskQueue.queueTask(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: this.title,
                    type: this.type,
                    content: this.content,
                    duration: this.duration
                }
            });
            if (this.closeOverlay) {
                this.ea.publish(Overlay.channel, {
                    type: OverlayEventType.CLOSE
                });
            }
        });

    }
}