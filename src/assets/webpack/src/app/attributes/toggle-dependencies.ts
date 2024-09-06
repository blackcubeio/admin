import {customAttribute, INode, IEventAggregator, ILogger, IDisposable, bindable, resolve} from 'aurelia';

@customAttribute('blackcube-toggle-dependencies')
export class ToggleDependencies
{
    public target: string = 'data-dependency';
    public source: string = 'data-dependency-source'
    private toggleElement :HTMLInputElement|null;
    private toggleTargets: NodeListOf<HTMLElement>;
    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('ToggleDependencies'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attached()
    {
        this.toggleElement = this.element.querySelector('['+this.source+']');
        if (this.toggleElement) {
            this.toggleTargets = this.element.querySelectorAll('['+this.target+']');
            if (this.toggleElement.checked) {
                this.activateFields();
            } else {
                this.deactivateFields();
            }
            this.toggleElement.addEventListener('change', this.onChange);
        }
    }

    public detaching(): void {
        if (this.toggleElement) {
            this.toggleElement.removeEventListener('change', this.onChange);
        }
    }

    protected onChange = (item:Event) => {
        let toggle = <HTMLInputElement>item.currentTarget;
        if (toggle.checked) {
            this.activateFields();
        } else {
            this.deactivateFields();
        }
    }

    protected activateFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            item.classList.remove('opacity-50');
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = false;
            });
        });
    }
    protected deactivateFields()
    {
        this.toggleTargets.forEach((item:HTMLElement) => {
            item.classList.add('opacity-50');
            item.querySelectorAll('input, select').forEach((item:HTMLInputElement|HTMLSelectElement) => {
                item.disabled = true;
            });
        });
    }
}