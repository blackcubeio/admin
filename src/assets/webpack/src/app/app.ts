import {IEventAggregator, ILogger} from '@aurelia/kernel';
import {Home} from "./pages/home";
import {INode} from "@aurelia/runtime-html";
import {Ajax} from "./pages/ajax";

export class App {
    static routes = [
        {
            path: '',
            component: Home,
            id: 'home'
        },
        {
            path: 'ajax',
            component: Ajax,
            id: 'ajax'
        },
    ];

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator
    ) {
        this.logger = logger.scopeTo('App');
    }
}