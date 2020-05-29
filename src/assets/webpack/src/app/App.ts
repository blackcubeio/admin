/**
 * App.ts
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2017 Ibitux
 * @license http://www.ibitux.com/license license
 * @version XXX
 * @link http://www.ibitux.com
 */

import {Router, RouterConfiguration, NavigationInstruction, RedirectToRoute} from 'aurelia-router'
import {inject, InlineViewStrategy, LogManager} from 'aurelia-framework';
import {Logger} from 'aurelia-logging';
import {PLATFORM} from 'aurelia-pal';

class App
{
    private router: Router;
    private logger:Logger = LogManager.getLogger('App');

    public constructor()
    {
        this.logger.debug('Constructor');
    }

    public attached()
    {
        this.logger.debug('Attached');
    }

    public async configureRouter(config: RouterConfiguration, router: Router) {
        config.title = '';
        // Retrieve data from wrapping div
        let bases = document.querySelectorAll('div[baseUrl]');
        if (bases.length > 0) {
            config.options.pushState = true;
            // @ts-ignore
            config.options.root = bases[0].getAttribute('baseUrl');
            // this.configService.publicBasePath = bases[0].getAttribute('baseUrl');
            // await this.configService.setConfigUrl(bases[0].getAttribute('configApiUrl'))
        }
        /*/
        config.addPostRenderStep({
            run(navigationInstruction: NavigationInstruction, next) {
                if (navigationInstruction.router.isNavigatingNew) {
                    // @ts-ignore
                    window.scrollTo(0, 0);
                }
                return next();
            }
        });
        /**/
        config.map([
            {route: ['/'], name: 'demo', moduleId: PLATFORM.moduleName('pages/Demo'/*, 'pages' /**/), nav: true, title: 'Bienvenue', settings: {registerStatus: 0}},
        ]);

        this.router = router;
    }
}

export {App}
