import {IEventAggregator, ILogger} from '@aurelia/kernel';
import {IRouteViewModel, Params} from "aurelia";
import {RouteNode} from "@aurelia/router-lite/dist/types/route-tree";
import {NavigationInstruction} from "@aurelia/router-lite/dist/types/instructions";

export class Home implements IRouteViewModel
{
    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator
    ) {
        this.logger = logger.scopeTo('Home');
    }

    canLoad(params: Params, next: RouteNode, current: RouteNode | null): boolean | NavigationInstruction | NavigationInstruction[] | Promise<boolean | NavigationInstruction | NavigationInstruction[]>
    {
        this.logger.debug('CanLoad', params);
        return Promise.resolve(true);
    }

    load(params: Params, next: RouteNode, current: RouteNode | null): void | Promise<void>
    {
        this.logger.debug('Load', params);
        return Promise.resolve();
    }
    canUnload(next: RouteNode | null, current: RouteNode): boolean | Promise<boolean>
    {
        this.logger.debug('CanUnload');
        return Promise.resolve(true);
    }
    unload(next: RouteNode | null, current: RouteNode): void | Promise<void>
    {
        this.logger.debug('Unload');
        return Promise.resolve();
    }

}