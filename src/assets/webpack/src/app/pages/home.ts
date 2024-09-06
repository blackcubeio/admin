import {IEventAggregator, ILogger, resolve} from 'aurelia';

export class Home
{
    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Home'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
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