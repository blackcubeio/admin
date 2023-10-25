import {IDisposable, IEventAggregator, ILogger} from "@aurelia/kernel";
import {IPlatform} from "aurelia";
import {HttpService} from "../services/http-service";
import {bindable, customElement, INode} from "@aurelia/runtime-html";
import {Overlay} from "./overlay";
import {OverlayEventType} from "../interfaces/overlay";
import {Broadcast, BroadcastElementEvent, BroadcastElementEventType} from "../interfaces/broadcast";

@customElement('blackcube-element-toolbar')
export class ElementToolbar
{
    @bindable() public slugTitle: string = 'Slug';
    @bindable() public slugUrl: string;
    @bindable() public slugActive: boolean = false;
    @bindable() public slugExists: boolean = false;
    @bindable() public sitemapTitle: string = 'Sitemap';
    @bindable() public sitemapUrl: string;
    @bindable() public sitemapActive: boolean = false;
    @bindable() public seoTitle: string = 'SEO';
    @bindable() public seoUrl: string;
    @bindable() public seoActive: boolean = false;
    @bindable() public showTags: boolean = true;
    @bindable() public tagsTitle: string = 'Tags';
    @bindable() public tagsUrl: string;
    @bindable() public linkUrl: string = '';
    @bindable() public linkTitle: string = 'View';
    private eventListener: IDisposable;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @IPlatform private readonly platform: IPlatform,
        private readonly httpService: HttpService,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('ElementToolbar');
    }

    public attaching() {
        this.eventListener  = this.ea.subscribe(Broadcast.channel, this.onEvent);
    }
    public attached(): void {
        this.logger.debug('Attached');

    }

    public detaching(): void {
        this.logger.debug('Detached');

    }

    private onEvent = (event:BroadcastElementEvent) => {
        if(event.data?.type === 'slug') {
            if (event.type === BroadcastElementEventType.CREATE || event.type === BroadcastElementEventType.UPDATE) {
                this.slugExists = true;
            } else if (event.type === BroadcastElementEventType.DELETE) {
                this.slugExists = false;
                this.slugActive = false;
                this.seoActive = false;
                this.sitemapActive = false;
            }
            if (event.type === BroadcastElementEventType.ACTIVATE) {
                this.slugActive = true;
            } else if (event.type === BroadcastElementEventType.DEACTIVATE) {
                this.slugActive = false;
            }
        }
        if(event.data?.type === 'seo') {
            if (event.type === BroadcastElementEventType.ACTIVATE) {
                this.seoActive = true;
            } else if (event.type === BroadcastElementEventType.DEACTIVATE) {
                this.seoActive = false;
            }
        }
        if(event.data?.type === 'sitemap') {
            if (event.type === BroadcastElementEventType.ACTIVATE) {
                this.sitemapActive = true;
            } else if (event.type === BroadcastElementEventType.DEACTIVATE) {
                this.sitemapActive = false;
            }
        }

    };
    public dispose()
    {
        this.eventListener.dispose();
    }

    public onClickSlug(event: Event)
    {
        event.preventDefault();
        this.ea.publish(Overlay.channel, {
            type: OverlayEventType.OPEN,
            overlay: {
                url: this.slugUrl,
            }
        });
    }

    public onClickSitemap(event: Event)
    {
        event.preventDefault();
        if (this.slugExists) {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    url: this.sitemapUrl,
                }
            });
        }
    }

    public onClickSeo(event: Event)
    {
        event.preventDefault();
        if (this.slugExists) {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    url: this.seoUrl,
                }
            });
        }
    }

    public onClickTags(event: Event)
    {
        event.preventDefault();
        this.ea.publish(Overlay.channel, {
            type: OverlayEventType.OPEN,
            overlay: {
                url: this.tagsUrl,
            }
        });
    }

}
