import {bindable, customElement, INode, IPlatform, ILogger, resolve} from "aurelia";
import {IHttpService} from "../services/http-service";

@customElement('blackcube-composites')
export class Composites
{
    @bindable() url: string;
    private form:HTMLFormElement;
    @bindable() public view: string = '';

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Composites'),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly httpService: IHttpService = resolve(IHttpService),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
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
