

import {ILogger} from "@aurelia/kernel";
import {IPlatform} from "aurelia";
import {HttpService} from "../services/http-service";
import {bindable, customElement, INode} from "@aurelia/runtime-html";

@customElement('blackcube-composites')
export class Composites
{
    @bindable() url: string;
    private form:HTMLFormElement;
    @bindable() public view: string = '';

    public constructor(
        @ILogger private readonly logger: ILogger,
        @IPlatform private readonly platform: IPlatform,
        private readonly httpService: HttpService,
        @INode private readonly element: HTMLElement
    ) {
        this.logger = logger.scopeTo('Composites');
    }


    public attached(): void {
        this.logger.debug('Attached');
        this.logger.debug(this.url);
        this.form = <HTMLFormElement>this.element.closest('form');
        this.element.addEventListener('click', this.onDelegateClick);
    }

    protected onDelegateClick = (evt:Event) => {
        if (evt.target) {
            evt.stopPropagation();
            //TODO: make better delegate
            //@ts-ignore
            let currentButton = <HTMLButtonElement>evt.target.closest('button[type=button]');
            if (currentButton && this.element.contains(currentButton)) {
                evt.preventDefault();
                this.logger.debug('delegateClick');
                if (currentButton.name) {
                    const body = new FormData(this.form);
                    const method = 'post';
                    body.append(currentButton.name, currentButton.value);
                    this.httpService.fetch(this.url, {body, method} )
                        .then(response => {
                            return response.text();
                        })
                        .then((html) => {
                            this.view = html;
                        });
                }
            }
        }
    };

    public detaching(): void {
        this.logger.debug('Detached');
        this.element.removeEventListener('click', this.onDelegateClick);
    }

}
