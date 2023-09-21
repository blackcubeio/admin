import {IEventAggregator, ILogger} from '@aurelia/kernel';
import {INode} from "@aurelia/runtime-html";

export class Enhance {
    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Enhance');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
    }
}