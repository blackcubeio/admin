import {IEventAggregator, ILogger} from '@aurelia/kernel';

export class Home
{
    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator
    ) {
        this.logger = logger.scopeTo('Home');
    }

    canLoad()
    {
        this.logger.debug('CanLoad');
        return Promise.resolve(true);
    }

    load(): void | Promise<void>
    {
        this.logger.debug('Load');
        return Promise.resolve();
    }
    canUnload(): boolean | Promise<boolean>
    {
        this.logger.debug('CanUnload');
        return Promise.resolve(true);
    }
    unload()
    {
        this.logger.debug('Unload');
        return Promise.resolve();
    }

}