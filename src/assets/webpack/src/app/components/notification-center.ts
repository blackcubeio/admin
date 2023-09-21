import {customElement, bindable, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { Notification } from './notification';
import {
    NotificationCenterEvent, NotificationCenterEventType,
    NotificationData,
    NotificationEvent,
    NotificationStatus
} from '../interfaces/notification';
import {ICustomElementViewModel} from "aurelia";

@customElement('blackcube-notification-center')
export class NotificationCenter implements ICustomElementViewModel
{
    public static readonly channel: string = 'NotificationCenter';

    public notifications: NotificationData[] = [];

    private subscriber: IDisposable;
    private subscriberNotification: IDisposable;

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('NotificationCenter');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        this.subscriberNotification = this.ea.subscribe(Notification.channel, this.onNotificationEvent);
        this.subscriber = this.ea.subscribe(NotificationCenter.channel, this.onNotificationCenterEvent);
    }

    public attached()
    {
        this.logger.trace('Attached');
    }

    public dispose()
    {
        this.subscriberNotification.dispose();
        this.subscriber.dispose();
    }

    private onNotificationEvent = (event: NotificationEvent) => {
        if (event.status === NotificationStatus.CLOSED) {
            this.logger.debug('Notification event', event);
            this.removeNotification(event.index);
        }
    }

    private onNotificationCenterEvent = (event: NotificationCenterEvent) => {
        if (event.type === NotificationCenterEventType.CREATE && event.notification) {
            this.logger.debug('Notification event', event);
            this.addNotification(event.notification);
        } else if (event.type === NotificationCenterEventType.REMOVE_ALL) {
            this.logger.debug('Should close children');
            this.notifications.splice(0, this.notifications.length)
        }
    }

    private addNotification(notification: NotificationData)
    {
        this.notifications.push(notification);
    }

    private removeNotification(index: number)
    {
        this.notifications.splice(index, 1);
    }
    public detaching()
    {
        this.logger.trace('Detaching');
    }


}