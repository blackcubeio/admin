import {
    customElement,
    ICustomElementViewModel,
    IPlatform,
    bindable,
    INode,
    IEventAggregator,
    ILogger,
    IDisposable,
    resolve
} from 'aurelia';
import { IHttpService } from '../services/http-service';
import { OverlayEvent, OverlayEventType, OverlayStatus } from '../interfaces/overlay';
import { transitionWithPromise } from '../helpers/transition';

@customElement('blackcube-overlay')
// @templateCompilerHooks()
export class Overlay implements ICustomElementViewModel
{
    public static readonly channel: string = 'Overlay';

    @bindable() public title: string = '';
    @bindable() public abstract: string = '';
    @bindable() public cancelTitle: string = '';
    @bindable() public actionTitle: string = '';
    public htmlData: string;
    public cancel?: Function;
    public action?: Function;

    public overlay:HTMLDivElement;
    public panel: HTMLDivElement;

    private subscriber: IDisposable;

    private isOpen = false;


    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Overlay'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly platform: IPlatform = resolve(IPlatform),
        private httpService: IHttpService = resolve(IHttpService),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        this.subscriber = this.ea.subscribe(Overlay.channel, this.onOverlayEvent);
    }


    public attached()
    {
        this.element.style.display = 'none';
        this.logger.trace('Attached');
        this.panel.addEventListener('submit', this.onDelegatedEvent); //, {capture: true});
        this.panel.addEventListener('click', this.onDelegatedEvent); //, {capture: true});
    }


    public detaching()
    {
        this.logger.trace('Detaching');
        this.panel.removeEventListener('click', this.onDelegatedEvent);
        this.panel.removeEventListener('submit', this.onDelegatedEvent);
    }

    public dispose() {
        this.subscriber.dispose();
    }

    private onOverlayEvent = (evt: OverlayEvent) => {
        if (evt.type === OverlayEventType.OPEN) {
            this.closeWithTransition()
                .then((status) => {
                    //@ts-ignore
                    this.title = evt.overlay.title;
                    //@ts-ignore
                    this.abstract = evt.overlay.abstract;
                    this.cancel = evt.overlay?.cancel;
                    this.action = evt.overlay?.action;
                    this.cancelTitle = evt.overlay?.cancelTitle || 'Cancel';
                    this.actionTitle = evt.overlay?.actionTitle || 'Action';
                    //@ts-ignore
                    return this.httpService.getHtmlContent(evt.overlay.url)
                })
                .then((html) => {

                    this.htmlData = html;
                    return new Promise<boolean>((resolve) => {
                        this.platform.setTimeout(() => {
                            // make sure everything is correct and html is injected
                            resolve(true);
                        }, 40);
                    });
                })
                .then((result) => {
                    // const au = new Aurelia();
                    // this.ctl = this.aurelia.enhance({host: this.outerElement, component: Enhance});
                    return this.openWithTransition();
                });

        } else if (evt.type === OverlayEventType.CLOSE) {
            this.closeWithTransition();
        }
    };


    private onDelegatedEvent = (evt: Event) => {
        // data-ajaxify-source=""
        const triggerElement = <HTMLElement>(<HTMLElement>evt.target)?.closest('[data-overlay-action]');
        const submitEvt = <SubmitEvent>evt;
        if (evt.type === 'click' && triggerElement && this.panel.contains(triggerElement)) {
            // c'est un click à monitorer
            if(triggerElement.dataset.overlayAction && triggerElement.dataset.overlayAction === 'close') {
                evt.stopPropagation();
                evt.preventDefault();
                this.onClickClose(evt);
                this.logger.warn('delegated ' + evt.type + ' done', evt.target, evt.type);
            }
            if(triggerElement.dataset.overlayAction && triggerElement.dataset.overlayAction === 'submit') {
                evt.stopPropagation();
                evt.preventDefault();
                const elementForm = <HTMLFormElement>(<HTMLElement>evt.target)?.closest('form');
                if (elementForm) {
                    const body: FormData = new FormData(elementForm);
                    if (triggerElement instanceof HTMLButtonElement && triggerElement.hasAttribute('name') && triggerElement.hasAttribute('value')) {
                        body.append(triggerElement.name, triggerElement.value);
                    }
                    this.httpService.fetch(elementForm.action, {method: elementForm.method, body})
                        .then((data) => {
                            const url = data.headers.get('X-Redirect')
                            if (url) {
                                window.location.href = url;
                                throw new Error('Should redirect');
                            }
                            return data.text();
                        }).then((html) => {
                            this.htmlData = html;
                    });
                }

            }

        } else if (evt.type === 'submit') {

            const elementForm = <HTMLFormElement>(<HTMLElement>evt.target)?.closest('form');
            submitEvt.preventDefault();
            if (elementForm) {
                // c'est un submit
                const formData: FormData = new FormData(elementForm);
                const submitter = <HTMLButtonElement|HTMLInputElement>submitEvt.submitter;

                if (submitter.hasAttribute('name') && submitter.hasAttribute('value')) {
                    //@ts-ignore
                    formData.append(submitter.name, submitter.value);
                }
                this.httpService.runFormRequest(elementForm.action, formData, elementForm.method)
                    .then((html) => {
                        this.htmlData = html;
                    });

                this.logger.warn('delegated ' + submitEvt.type + ' done');
            }
        }
    };

    public onClickClose = (evt: Event) =>
    {
        if (this.cancel) {
            this.cancel();
        }
        this.closeWithTransition();
    };

    private openWithTransition(): Promise<boolean>
    {
        if (this.isOpen === false) {
            this.isOpen = true;
            return transitionWithPromise(
                {
                    element: this.element,
                    beforeDisplayStyle: 'inherit',
                    startingCallback: () => {
                        this.ea.publish(Overlay.channel, {
                            status: OverlayStatus.OPENING
                        });
                        //this.attachButtons();
                    },
                    endingCallback: () => {
                        this.ea.publish(Overlay.channel, {
                            status: OverlayStatus.OPENED
                        });
                    }
                },
                [
                    {element: this.overlay, from: ['closed'], to: ['opened'], transition: ['opening']},
                    {element: this.panel, from: ['closed'], to: ['opened'], transition: ['opening']}
                ]
            );
        } else {
            return Promise.resolve(true);
        }
    }

    private closeWithTransition(): Promise<boolean>
    {
        if (this.isOpen === true) {
            this.isOpen = false;

            //this.detachButtons();
            return transitionWithPromise(
                {
                    element: this.element,
                    afterDisplayStyle: 'none',
                    startingCallback: () => {
                        this.ea.publish(Overlay.channel, {
                            status: OverlayStatus.CLOSING
                        });
                    },
                    endingCallback: () => {
                        this.htmlData = '';
                        this.ea.publish(Overlay.channel, {
                            status: OverlayStatus.CLOSED
                        });
                    }
                },
                [
                    {element: this.overlay, from: ['opened'], to: ['closed'], transition: ['closing']},
                    {element: this.panel, from: ['opened'], to: ['closed'], transition: ['closing']}
                ]
            );
        } else {
            return Promise.resolve(true);
        }
    }

}