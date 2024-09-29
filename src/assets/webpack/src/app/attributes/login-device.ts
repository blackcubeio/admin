import {bindable, IPlatform, customAttribute, INode, IEventAggregator, ILogger, IDisposable, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";
import { IWebauthnService } from '@blackcube/aurelia2-webauthn';

@customAttribute('blackcube-login-device')
export class LoginDevice
{
    @bindable() targetUrl: string = '';
    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('LoginDevice'),
        private readonly platform: IPlatform = resolve(IPlatform),
        private webauthnService: IWebauthnService = resolve(IWebauthnService),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attaching()
    {
        this.logger.trace('Attaching');
        this.webauthnService.isAvailable().then((available) => {
            if (available) {
                this.element.classList.remove('hidden');
                this.logger.debug('WebAuthn is available');
            } else {
                this.logger.debug('WebAuthn is not available');
                this.element.remove();
            }
        });
    }

    public attached()
    {
        this.element.addEventListener('click', this.onDelegateEvent);
        this.logger.trace('Attached');
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.element.removeEventListener('click', this.onDelegateEvent);
    }

    private onDelegateEvent = (evt: Event) => {
        evt.preventDefault();
        this.logger.trace('onDelegateEvent');
        this.webauthnService.loginDevice()
            .then((status: boolean) => {
                if (status) {
                    this.logger.debug('Attach success');
                    this.platform.window.location.href = this.targetUrl;
                } else {
                    this.logger.error('Attach failed');
                }
            });

    };

}