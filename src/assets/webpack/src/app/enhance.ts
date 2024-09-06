import {ILogger, resolve} from 'aurelia';


export class Enhance {
    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Enhance'),
    ) {
    }

    public attaching()
    {
        this.logger.trace('Attaching');
    }
}