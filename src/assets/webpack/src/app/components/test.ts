import {customElement, bindable, watch, BindingMode, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { ProfileMenuItem, ProfileStatus } from '../interfaces/profile';
import {IPlatform} from "aurelia";
import {AlertEventType, AlertType} from "../interfaces/alert";
import {Alert} from "./alert";

@customElement('blackcube-test')
export class Test
{


    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator
    ) {
        this.logger = logger.scopeTo('Profile');
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