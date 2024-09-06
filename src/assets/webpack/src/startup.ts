
import Aurelia, {ConsoleSink, LoggerConfiguration, LogLevel} from "aurelia";
import * as globalAttributes from './app/attributes/index';
import * as globalComponents from './app/components/index';
import {Enhance} from "./app/enhance";

declare var webpackBaseUrl: string;
declare var __webpack_public_path__: string;
if ((window as any).webpackBaseUrl) {
    __webpack_public_path__ = webpackBaseUrl;
}
declare var PRODUCTION:boolean;



const page = document.querySelector('body') as HTMLElement;
const au = Aurelia.register(globalAttributes)
    .register(globalComponents);
if(PRODUCTION == false) {
    au.register(LoggerConfiguration.create({
            level: LogLevel.trace,
            colorOptions: 'colors',
            sinks: [ConsoleSink]
        }));
} else {
}

au.enhance({
    host: page,
    component: Enhance
});
