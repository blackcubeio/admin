import { HttpClientConfiguration, IHttpClient } from '@aurelia/fetch-client';

export interface Csrf {
    name:string,
    value:string
}

export class HttpService {

    public constructor(
        @IHttpClient private readonly httpClient: IHttpClient
    )
    {
        this.httpClient.configure((config: HttpClientConfiguration) => {
            config.withDefaults({
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                },
                credentials: 'include'
            });
            return config;
        });
    }

    public getHtmlContent(url: string): Promise<string>
    {
        const requestInit: RequestInit = {
            headers: {
                'Accept': 'text/html'
            }
        };
        return this.httpClient.get(url, requestInit)
            .then((response) => {
                return response.text();
            });
    }

    public runFormRequest(url: string, body: FormData|null = null, method: string = 'post'): Promise<any>
    {
        return this.httpClient.fetch(url, {
            method: method.toLocaleLowerCase(),
            body,
        })
            .then((response:Response) => {
                return response.text();
            });
    }

    public fetch(input: Request | string, init?: RequestInit): Promise<Response>
    {
        return this.httpClient.fetch(input, init);
    }

    public deleteRequest(url:string, csrf:string = '')
    {
        return this.httpClient.fetch(url, { method: 'delete', headers: {'X-CSRF-Token': csrf}});
    }
}