import {inject, LogManager} from "aurelia-framework";
import {HttpClient, HttpClientConfiguration} from "aurelia-fetch-client";
import {Logger} from "aurelia-logging";

@inject(HttpClient)
class AjaxService {
    private httpClient:HttpClient;
    private logger:Logger = LogManager.getLogger('services.AjaxService');

    constructor(httpClient:HttpClient) {
        this.httpClient = httpClient;
        this.httpClient.configure(config => {
            config
                .withDefaults({
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials:'include'
                });
        });
        this.logger.debug('Constructor');
    }

    public getBlocs(route:string, formData:FormData)
    {
        this.logger.debug('getBlocs', route);
        return this.httpClient.fetch(route, {
            method: 'post',
            body: formData,
        });
    }
}

export {AjaxService}
