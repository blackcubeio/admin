import {IEventAggregator, ILogger, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";

export class Ajax
{

    public data: string = 'slotted';

    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Ajax'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly httpService: IHttpService = resolve(IHttpService),
    ) {
    }

    canLoad()
    {
        this.logger.debug('CanLoad');
        return Promise.resolve(true);
    }

    load(): void | Promise<void>
    {
        this.logger.debug('Load');
        return this.httpService.getHtmlContent('/blackcube-cms-admin-aurelia2/data.html')
            .then((htmlData) => {
                this.data = htmlData;
                return Promise.resolve() ;
            })
        // return Promise.resolve();
    }
    canUnload(): boolean | Promise<boolean>
    {
        this.logger.debug('CanUnload');
        return Promise.resolve(true);
    }
    unload(): void | Promise<void>
    {
        this.logger.debug('Unload');
        return Promise.resolve();
    }

}