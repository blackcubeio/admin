import {IEventAggregator, ILogger} from "@aurelia/kernel";
import {NotificationCenter, Overlay} from '../components';
import {NotificationCenterEventType, NotificationType} from '../interfaces/notification';
import {bindable, customAttribute, INode} from "@aurelia/runtime-html";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomAttributeViewModel, IPlatform} from "aurelia";

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
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @IPlatform private readonly platform: IPlatform,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('NotificationTrigger');
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