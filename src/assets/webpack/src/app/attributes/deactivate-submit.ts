import {IPlatform, bindable, customAttribute, INode, IEventAggregator, ILogger, IDisposable, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";
import {IStorageService} from "../services/storage-service";

@customAttribute('blackcube-deactivate-submit')
export class DeactivateSubmit
{
    private submitButtons: NodeListOf<HTMLElement>;
    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Fold'),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attaching()
    {
        this.logger.trace('Attaching');
        if (this.element instanceof HTMLFormElement) {
            this.submitButtons = this.element.querySelectorAll('button[type="submit"], input[type="submit"]');
        }
    }

    public attached()
    {
        this.element.addEventListener('submit', this.onSubmit);
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.element.removeEventListener('submit', this.onSubmit);
    }

    private onSubmit = (event: Event) => {
        this.logger.trace('Submit event', event);
        this.submitButtons.forEach((submitButton: HTMLElement) => {
            this.logger.trace('Submit button text', submitButton);
            submitButton.setAttribute('disabled', 'disabled');
        });
    }


}