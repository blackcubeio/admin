import {IEventAggregator, ILogger} from '@aurelia/kernel';
import {IRouteViewModel, Params} from "aurelia";
import {RouteNode} from "@aurelia/router-lite/dist/types/route-tree";
import {NavigationInstruction} from "@aurelia/router-lite/dist/types/instructions";
import {HttpService} from "../services/http-service";

export class Ajax implements IRouteViewModel
{

    public data: string = 'slotted';

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        private readonly httpService: HttpService,
    ) {
        this.logger = logger.scopeTo('Ajax');
    }

    canLoad(params: Params, next: RouteNode, current: RouteNode | null): boolean | NavigationInstruction | NavigationInstruction[] | Promise<boolean | NavigationInstruction | NavigationInstruction[]>
    {
        this.logger.debug('CanLoad', params);
        return Promise.resolve(true);
    }

    load(params: Params, next: RouteNode, current: RouteNode | null): void | Promise<void>
    {
        this.logger.debug('Load', params);
        return this.httpService.getHtmlContent('/blackcube-cms-admin-aurelia2/data.html')
            .then((htmlData) => {
                this.data = htmlData;
                return Promise.resolve() ;
            })
        // return Promise.resolve();
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