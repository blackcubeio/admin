import {ILogger, INode, IEventAggregator, resolve} from "aurelia";
import {} from '@aurelia/runtime-html';

export class BcTestCustomAttribute
{
    private openMenuBtn: HTMLButtonElement;
    constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('BcTestCustomAttribute'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    ) {
        this.logger = logger.scopeTo('BcTestCustomAttribute');
    }

    public attaching()
    {
        this.logger.trace('Attaching');
        /*/
        this.openMenuBtn = this.element.querySelector('[x-ref=opensidebar]') as HTMLButtonElement;
        this.openMenuBtn.addEventListener('click', (evt: Event) => {
            evt.preventDefault();
            this.ea.publish(Menu.channel, {type: MenuEventType.OPEN});
        });
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    title: 'Titre Overlay 1',
                    abstract: 'Contenu Alerte',
                    url: '/form.html'
                }
            });

        }, 5000);
        setTimeout(() => {
            this.ea.publish(Overlay.channel, {
                type: OverlayEventType.OPEN,
                overlay: {
                    title: 'Titre Overlay 2',
                    abstract: 'Contenu Alerte',
                    url: '/form.html',
                    actionTitle: 'Save',
                    cancel: () => { this.logger.warn('Clicked cancel')}
                }
            });

        }, 8000);
        /**/
        /*/
        setTimeout(() => {
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
        }, 2500);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(Alert.channel, {
                type: AlertEventType.CLOSE,
                alert: {
                    type: AlertType.EXCLAMATION,
                    title: 'Titre Alerte',
                    content: 'Contenu Alerte'
                }
            });
        }, 12500);
        /**/

        /*/
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 1500);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 2000);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 2500);
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.CREATE,
                notification: {
                    title: 'Test stuff',
                    type: NotificationType.EXCLAMATION,
                    content: 'Et le contenu de la notification',
                    duration: 5000                }
            });
        }, 3000);
        /**/
        /*/
        setTimeout(() => {
            this.ea.publish(NotificationCenter.channel, {
                type: NotificationCenterEventType.REMOVE_ALL
            });
        }, 5500);
        /**/
    }
}