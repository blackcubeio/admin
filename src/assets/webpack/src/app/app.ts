import {IEventAggregator, ILogger, INode} from 'aurelia';
import {Home} from "./pages/home";
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