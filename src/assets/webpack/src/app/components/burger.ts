import {
    customElement,
    containerless,
    ICustomElementViewModel,
    bindable,
    INode,
    IEventAggregator,
    ILogger,
    IDisposable,
    resolve
} from 'aurelia';
import {Menu} from "../attributes";
import {MenuEventType} from "../interfaces/menu";


@customElement('blackcube-burger')
@containerless()
export class Burger implements ICustomElementViewModel
{
    private openMenuBtn: HTMLButtonElement;
    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Burger'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        this.openMenuBtn.addEventListener('click', this.onClick);

    }

    private onClick = (event: Event) => {
        // this.stackedAlerts.push(event);
        event.preventDefault();
        this.ea.publish(Menu.channel, {type: MenuEventType.OPEN});

    };

    public attached()
    {
        this.logger.trace('Attached');
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        this.openMenuBtn.removeEventListener('click', this.onClick);
    }


}