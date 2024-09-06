import {
    customElement,
    bindable,
    watch,
    INode,
    IEventAggregator,
    ILogger,
    IDisposable,
    IPlatform,
    resolve
} from "aurelia";
import {AlertEventType, AlertType} from "../interfaces/alert";
import {Alert} from "./alert";

@customElement('blackcube-test')
export class Test
{


    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Test'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
    ) {
    }

    public attaching()
    {
        this.logger.trace('Attaching');
    }
    public attached()
    {
        this.logger.trace('Attached');
    }
    public bound() {
        this.logger.trace('Bound');
    }
    public detaching()
    {
        this.logger.trace('Detaching');

    }

    public onClick(evt: Event)
    {
        evt.preventDefault();
        this.logger.warn('Click');
        this.ea.publish(Alert.channel, {
            type: AlertEventType.OPEN,
            alert: {
                type: AlertType.QUESTION,
                title: 'Titre Alerte',
                content: 'Contenu Alerte',
                action: () => {
                    this.logger.warn('Closing with action')
                },
                cancel: () => {
                    this.logger.warn('Closing with cancel')
                }
            }
        });
    }

}