import {IEventAggregator, ILogger} from '@aurelia/kernel';
import {HttpService} from "../services/http-service";

export class Ajax
{

    public data: string = 'slotted';

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        private readonly httpService: HttpService,
    ) {
        this.logger = logger.scopeTo('Ajax');
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