import {customAttribute, INode, IEventAggregator, ILogger, IDisposable, IPlatform, bindable, resolve} from 'aurelia';
import {IHttpService} from "../services/http-service";
import {IStorageService} from "../services/storage-service";

@customAttribute('blackcube-view-edit')
export class ViewEdit
{

    private elements: NodeListOf<Element>;
    private toggleButton: HTMLElement;

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('ViewEdit'),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attaching()
    {
        this.logger.trace('Attaching');
    }

    public attached()
    {
        this.elements = this.element.querySelectorAll('[data-view-edit]');
        this.toggleButton = this.element.querySelector('[data-view-edit=toggle] button');
        this.toggleButton?.addEventListener('click', this.onToggleEvent);
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.toggleButton?.removeEventListener('click', this.onToggleEvent);
    }


    private onToggleEvent = (evt: Event) => {
        this.elements.forEach((element) => {
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
            } else {
                element.classList.add('hidden');
            }
        });
    };

}