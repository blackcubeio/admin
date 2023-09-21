import { customAttribute, INode, bindable } from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {Alert, Overlay} from "../components";
import {OverlayEventType} from "../interfaces/overlay";
import {ICustomAttributeViewModel} from "aurelia";
import {AlertEventType, AlertType} from "../interfaces/alert";
import {Csrf, HttpService} from "../services/http-service";

@customAttribute('blackcube-alert-delete')
export class AlertDelete implements ICustomAttributeViewModel
{
    @bindable() public action: string = 'Delete';
    @bindable() public cancel: string = 'Cancel';

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        private httpService: HttpService,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('ModalAlert');
    }
    public attaching()
    {
        this.logger.trace('Attaching');
    }

    public attached()
    {
        this.logger.trace('Attached');
        this.element.addEventListener('click', this.onDelegateEvent);
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }

    private onDelegateEvent = (event: Event) => {
        if (event.target) {
            const el = <HTMLElement>event.target;
            const triggerElement = <HTMLElement>el.closest('[data-alert-delete]');
            if (triggerElement instanceof HTMLAnchorElement) {
                const contentUrl = triggerElement.dataset.alertDelete;
                const method = triggerElement.dataset.alertDeleteMethod || 'post';
                const targetUrl = triggerElement.href;
                if (contentUrl && contentUrl.length > 1) {
                    event.preventDefault();
                    this.ea.publish(Alert.channel, {
                        type: AlertEventType.OPEN,
                        alert: {
                            type: AlertType.EXCLAMATION,
                            contentUrl,
                            actionTitle: this.action,
                            cancelTitle: this.cancel,
                            cancel: () => { this.logger.trace('Should Close'); },
                            action: () => {
                                const csrfField = <HTMLInputElement>triggerElement.closest('form')?.querySelector('input[name=_csrf]');
                                const body = new FormData();
                                if (csrfField) {
                                    body.append(csrfField.name, csrfField.value);
                                }

                                this.httpService.fetch(targetUrl, {method, body})
                                    .then((data) => {
                                        const url = data.headers.get('X-Redirect')
                                        if (url) {
                                            window.location.href = url;
                                        }
                                        this.logger.trace('daya', data.headers)
                                    });
                                // window.location.href = targetUrl;
                            }
                        }
                    });
                }

            }
        }

    };
}