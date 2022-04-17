import Aurelia, {RouterConfiguration} from 'aurelia';
import { ConsoleSink, LoggerConfiguration, LogLevel } from '@aurelia/kernel';

declare var webpackBaseUrl: string;
declare var __webpack_public_path__: string;
if ((window as any).webpackBaseUrl) {
    __webpack_public_path__ = webpackBaseUrl;
}

import * as globalAttributes from './app/attributes/index';
import * as globalComponents from './app/components/index';
import { App } from './app/app';
import {Enhance} from "./app/enhance";

const page = document.querySelector('body') as HTMLElement;
console.log('before startup', page);

Aurelia
    .register(globalAttributes)
    .register(globalComponents)
    .register(LoggerConfiguration.create({
        level: LogLevel.trace,
        colorOptions: 1,
        sinks: [ConsoleSink]
    }))
    /*/
     .register(RouterConfiguration.customize({
        useUrlFragmentHash: true
    }))
    .app({
        component: App,
        host: document.body
    })
    .start();
    /**/
    .enhance({
        host: page,
        component: Enhance
    });
    /**/
