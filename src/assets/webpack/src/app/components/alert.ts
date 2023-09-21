import {customElement, bindable, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { AlertEvent, AlertEventType, AlertStatus, AlertType } from '../interfaces/alert';
import { transitionWithPromise } from '../helpers/transition';
import {ICustomAttributeViewModel, ICustomElementViewModel} from "aurelia";
import {HttpService} from "../services/http-service";


@customElement('blackcube-alert')
export class Alert implements ICustomElementViewModel
{
    public static readonly channel: string = 'Alert';

    public alertTypes = AlertType;
    public wrapper: HTMLDivElement;
    public panel: HTMLDivElement;

    @bindable() public type: AlertType = AlertType.QUESTION;
    public cancelTitle: string = 'Cancel';
    public actionTitle: string = 'Action';
    public cancel: Function|undefined;
    public action: Function|undefined;

    private contentUrl: string;
    private htmlData: string;

    private subscription: IDisposable;

    private stackedAlerts: AlertEvent[] = [];
    private alertShown: boolean = false;

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        private httpService: HttpService,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Alert');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        this.element.style.display = 'none';
        this.subscription = this.ea.subscribe(Alert.channel, this.onAlertEvent);
    }

    private onAlertEvent = (event: AlertEvent) => {
        // this.stackedAlerts.push(event);
        if (event.type === AlertEventType.OPEN && event.alert) {
            this.type = event.alert.type;
            if (event.alert.actionTitle) {
                this.actionTitle = event.alert.actionTitle;
            }
            if (event.alert.cancelTitle) {
                this.cancelTitle = event.alert.cancelTitle;
            }
            this.contentUrl = event.alert.contentUrl;
            this.action = event.alert.action;
            this.cancel = event.alert.cancel;
            this.httpService.getHtmlContent(this.contentUrl)
                .then((html) => {
                    this.htmlData = html;
                    return true;
                })
                .then((res) => {
                    this.logger.warn('Opening alert');
                    this.openWithTransition();
                });

        } else if (event.type === AlertEventType.CLOSE) {
            this.closeWithTransition();
        }
    };

    public attached()
    {
        this.logger.trace('Attached');
    }

    public detaching()
    {
        this.logger.trace('Detaching');
    }

    private openWithTransition(): Promise<boolean>
    {
        return transitionWithPromise({
            element: this.element,
            beforeDisplayStyle: 'inherit',
            startingCallback: () => {
                this.logger.warn('opening');
                this.ea.publish(Alert.channel, {
                    status: AlertStatus.OPENING
                });
            },
            endingCallback: () => {
                this.logger.warn('opened');
                this.ea.publish(Alert.channel, {
                    status: AlertStatus.OPENED
                });
                this.alertShown = true;
            }
        }, [
            {element: this.wrapper, from: ['closed'], to: ['opened'], transition: ['opening']},
            {element: this.panel, from: ['closed'], to: ['opened'], transition: ['opening']}
        ]);

    }

    private closeWithTransition(): Promise<boolean>
    {
        return transitionWithPromise({
            element: this.element,
            afterDisplayStyle: 'none',
            startingCallback: () => {
                this.ea.publish(Alert.channel, {
                    status: AlertStatus.CLOSING
                });
            },
            endingCallback: () => {
                this.ea.publish(Alert.channel, {
                    status: AlertStatus.CLOSED
                });
                this.alertShown = true;
            }
        }, [
            {element: this.wrapper, from: ['opened'], to: ['closed'], transition: ['closing']},
            {element: this.panel, from: ['opened'], to: ['closed'], transition: ['closing']}
        ]);
    }
    public onClickAction(evt: Event)
    {
        evt.preventDefault();
        this.logger.debug('Click action');
        if (this.action) {
            this.action();
        }
        this.closeWithTransition();
    }

    public onClickCancel(evt: Event)
    {
        evt.preventDefault();
        this.logger.debug('Click cancel');
        if (this.cancel) {
            this.cancel();
        }
        this.closeWithTransition();
    }

}