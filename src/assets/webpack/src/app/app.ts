import {ILogger, INode, resolve} from 'aurelia';
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
        private readonly logger: ILogger = resolve(ILogger).scopeTo('App'),
    ) {
        this.logger.debug('Construct');
    }
}