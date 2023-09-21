import {customElement, bindable, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { NotificationStatus, NotificationType } from '../interfaces/notification';
import { transitionWithPromise } from '../helpers/transition';
import {ICustomElementViewModel, IPlatform} from "aurelia";


@customElement('blackcube-notification')
export class Notification implements ICustomElementViewModel
{
    public static readonly channel: string = 'Notification';

    public notificationTypes = NotificationType;
    public wrapper: HTMLDivElement;

    @bindable() public type: NotificationType = NotificationType.INFORMATION;
    @bindable() public title: string = '';
    @bindable() public content: string = '';
    @bindable() public index: number;
    @bindable() public duration: number;

    private closeTimer: ReturnType<typeof setTimeout>;
    private closePromise: Promise<boolean>;

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @IPlatform private readonly platform: IPlatform,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Notification');
    }

    public attaching()
    {
        this.logger.trace('Attaching', this.duration);
        if (!this.duration) {
            this.duration = 5000;
        }
    }

    public attached()
    {
        this.logger.trace('Attached');
        this.openWithTransition();
        //@ts-ignore
        this.closeTimer = this.platform.setTimeout(() => {
            this.logger.trace('Auto close');
            this.closeWithTransition();
        }, this.duration);

    }

    public detaching()
    {
        this.logger.trace('Detaching');
        if (this.wrapper.classList.contains('opened')) {
            return this.closeWithTransition()
                .then((value) => {
                    return Promise.resolve();
                });
        } else {
            return Promise.resolve();
        }
    }

    public onClose(evt: Event)
    {
        evt.preventDefault();
        this.closeWithTransition();
    }

    private closeWithTransition(): Promise<boolean>
    {
        if (this.closeTimer) {
            this.platform.clearTimeout(this.closeTimer);
        }
        return transitionWithPromise(
            {
                element: this.wrapper,
                afterDisplayStyle: 'none',
                startingCallback: () => {
                    this.ea.publish(Notification.channel, {
                        status: NotificationStatus.CLOSING,
                        index: this.index
                    });
                },
                endingCallback: () => {
                    this.ea.publish(Notification.channel, {
                        status: NotificationStatus.CLOSED,
                        index: this.index
                    });
                }
            },
            [
                {element: this.wrapper, from: ['opened'], to: ['closed'], transition: ['closing']}
            ]
        );
    }

    private openWithTransition(): Promise<boolean>
    {
        return transitionWithPromise(
            {
                element: this.wrapper,
                beforeDisplayStyle: 'inherit',
                startingCallback: () => {
                    this.ea.publish(Notification.channel, {
                        status: NotificationStatus.OPENING,
                        index: this.index
                    });
                },
                endingCallback: () => {
                    this.ea.publish(Notification.channel, {
                        status: NotificationStatus.OPENED,
                        index: this.index
                    });
                }
            },
            [
                {element: this.wrapper, from: ['closed'], to: ['opened'], transition: ['opening']}
            ]
        );
    }

}