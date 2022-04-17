import {customAttribute, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {IPlatform} from "aurelia";
import {HttpService} from "../services/http-service";

@customAttribute('blackcube-ajaxify')
export class Ajaxify
{

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IPlatform private readonly platform: IPlatform,
        private readonly httpService: HttpService,
        @INode private readonly element: HTMLElement
    )
    {
        this.logger = logger.scopeTo('Ajaxify');
    }
    public attaching()
    {
        this.logger.trace('Attaching');
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
        if (evt.target) {
            const el = <HTMLElement>evt.target;
            const triggerElement = <HTMLElement>el.closest('[data-ajaxify-source]');
            if (triggerElement) {
                const source = triggerElement.dataset.ajaxifySource;
                let url = triggerElement.dataset.ajaxifyUrl;
                if (!url && (triggerElement instanceof HTMLLinkElement || triggerElement instanceof HTMLAnchorElement)) {
                    url = triggerElement.href;
                }
                const targetElement = this.element.querySelector('[data-ajaxify-target="' +source+ '"]') as HTMLElement;
                if (source && url && targetElement) {
                    evt.preventDefault();
                    this.httpService.getHtmlContent(url)
                        .then((htmlData) => {
                            targetElement.innerHTML = htmlData;
                            this.platform.taskQueue.queueTask(() => {
                                targetElement.scrollIntoView({behavior: "smooth"})
                            });

                        });
                }

            }
        }

    };

}