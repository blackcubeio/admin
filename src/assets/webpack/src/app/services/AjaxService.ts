import {inject, LogManager} from "aurelia-framework";
import {HttpClient, HttpClientConfiguration} from "aurelia-fetch-client";
import {Logger} from "aurelia-logging";

interface Csrf {
    name:string,
    value:string
}

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

    private modal:any = null;
    public getModal()
    {
        this.logger.debug('getModal');
        if (this.modal === null) {
            this.modal =  this.httpClient.fetch('/admin/ajax/modal', {
                method: 'get'
            }).then((response:Response) => {
                return response.text();
            });
        }
        return this.modal;
    }
    public getDetailModal(type:string, id:string)
    {
        this.logger.debug('getDetailModal');
        this.modal =  this.httpClient.fetch('/admin/ajax/modal?id='+id+'&type='+type, {
            method: 'get'
        }).then((response:Response) => {
            return response.text();
        });
        return this.modal;

    }
    public getRequest(url:string)
    {
        this.logger.debug('getRequest');
        return this.httpClient.fetch(url, { method: 'get'})
            .then((response:Response) => {
                return response.text();
            });
    }

    public getRequestJson(url:string)
    {
        this.logger.debug('getRequestJson', url);
        return this.httpClient.fetch(url, {
            method: 'get',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
            .then((response:Response) => {
                return response.json();
            });
    }
    public postRequest(url:string, formData:FormData)
    {
        this.logger.debug('postRequest', url);
        return this.httpClient.fetch(url, {
            method: 'post',
            body: formData,
        })
            .then((response:Response) => {
                return response.text();
            });
    }

    public postRequestJson(url:string, formData:any)
    {
        this.logger.debug('postRequest', url);
        return this.httpClient.fetch(url, {
            method: 'post',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(formData),
        })
            .then((response:Response) => {
                if (response.status === 200) {
                    return response.json();
                }
                throw new Error('Nothing found')
            });
    }

    public deleteRequest(url:string, csrf:string = '')
    {
        this.logger.debug('deleteRequest');
        return this.httpClient.fetch(url, { method: 'delete', headers: {'X-CSRF-Token': csrf}});
    }
    public updateRbac(url:string, formData:FormData)
    {
        this.logger.debug('updateRbac');
        return this.httpClient.fetch(url, {
            method: 'post',
            body: formData
        });

    }
}

export {AjaxService, Csrf}
