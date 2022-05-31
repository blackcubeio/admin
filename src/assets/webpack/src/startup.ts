import Aurelia, {RouterConfiguration} from 'aurelia';
import { ConsoleSink, LoggerConfiguration, LogLevel } from '@aurelia/kernel';

declare var webpackBaseUrl: string;
declare var __webpack_public_path__: string;
if ((window as any).webpackBaseUrl) {
    __webpack_public_path__ = webpackBaseUrl;
}
declare var PRODUCTION:boolean;

import * as globalAttributes from './app/attributes/index';
import * as globalComponents from './app/components/index';
import { App } from './app/app';
import {Enhance} from "./app/enhance";

const page = document.querySelector('body') as HTMLElement;

if(PRODUCTION == false) {
    Aurelia
        .register(globalAttributes)
        .register(globalComponents)
        .register(LoggerConfiguration.create({
            level: LogLevel.trace,
            colorOptions: 1,
            sinks: [ConsoleSink]
        }))
        .enhance({
            host: page,
            component: Enhance
        });
} else {
    Aurelia
        .register(globalAttributes)
        .register(globalComponents)
        .enhance({
            host: page,
            component: Enhance
        });
}

