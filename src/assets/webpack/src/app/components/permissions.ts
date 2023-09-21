

import {ILogger} from "@aurelia/kernel";
import {IPlatform} from "aurelia";
import {Csrf, HttpService} from "../services/http-service";
import {bindable, customElement, INode} from "@aurelia/runtime-html";

@customElement('blackcube-permissions')
export class Permissions
{
    @bindable() url: string;
    private form:HTMLFormElement;
    @bindable() public view: string = '';
    private csrf:Csrf;

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IPlatform private readonly platform: IPlatform,
        private readonly httpService: HttpService,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Permissions');
    }


    public attached(): void {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = <HTMLFormElement>this.element.closest('form');
        let csrfField = <HTMLInputElement>this.form.querySelector('input[name=_csrf]');
        this.csrf = {
            name: csrfField.name,
            value: csrfField.value
        };
        this.logger.debug(this.form);
        this.element.addEventListener('change', this.onDelegateChange);
        const body = new FormData();
        body.append(this.csrf.name, this.csrf.value);
        // const body = new FormData(this.form);
        const method = 'post';
        this.httpService.fetch(this.url, {body, method} )
            .then(response => {
                return response.text();
            })
            .then((html) => {
                this.view = html;
            });
    }


    protected onDelegateChange = (evt:Event) => {
        if (evt.target) {
            //TODO: make better delegate
            //@ts-ignore
            let currentCheckbox = <HTMLInputElement>evt.target.closest('input[type=checkbox]');
            if (currentCheckbox && this.element.contains(currentCheckbox)) {
                evt.stopPropagation();
                evt.preventDefault();
                this.logger.debug('delegateClick');
                const body = new FormData();
                body.append(this.csrf.name, this.csrf.value);
                if (currentCheckbox.dataset.rbacType) {
                    //@ts-ignore
                    body.append('type', currentCheckbox.dataset.rbacType);
                }
                if (currentCheckbox.dataset.rbacName) {
                    //@ts-ignore
                    body.append('name', currentCheckbox.dataset.rbacName);
                }
                body.append('mode', currentCheckbox.checked ? 'add' : 'remove');
                // const body = new FormData(this.form);
                const method = 'post';
                this.httpService.fetch(this.url, {body, method} )
                    .then(response => {
                        return response.text();
                    })
                    .then((html) => {
                        this.view = html;
                    });

            }
        }
    };

    public detaching(): void {
        this.logger.debug('Detached');
        this.element.removeEventListener('change', this.onDelegateChange);
    }

}
