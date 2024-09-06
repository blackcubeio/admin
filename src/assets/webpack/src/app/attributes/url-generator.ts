import {bindable, IPlatform, customAttribute, INode, IEventAggregator, ILogger, IDisposable, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";

@customAttribute('blackcube-url-generator')
export class UrlGenerator
{
    private button:HTMLElement = null;
    private target:HTMLInputElement = null;
    @bindable({primary:true})private url:string = null;

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('UrlGenerator'),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly httpService: IHttpService = resolve(IHttpService),
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
        this.button = this.element.querySelector('[data-url-generator=button]');
        this.target = this.element.querySelector('[data-url-generator=target]');
        if (this.button && this.target) {
            this.button.addEventListener('click', this.onDelegateEvent);
        }
        this.logger.trace('Attached');
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        if (this.button && this.target) {
            this.button.removeEventListener('click', this.onDelegateEvent);
        }
    }

    private onDelegateEvent = (evt: Event) => {
        evt.preventDefault();
        this.logger.trace('onDelegateEvent', this.url);
        this.httpService.fetch(this.url)
            .then((response) => {
                if (response.ok && response.status === 200) {
                    return response.json();
                } else {
                    return Promise.reject(response);
                }
            })
            .then((data) => {
                this.logger.trace('onDelegateEvent', data);
                this.target.value = data.url;
            })
            .catch((error) => {
                this.logger.warn('onDelegateEvent: error', error);
            });

    };

}