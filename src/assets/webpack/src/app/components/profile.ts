import {customElement, bindable, watch, BindingMode, INode} from '@aurelia/runtime-html';
import { IEventAggregator, ILogger, IDisposable } from '@aurelia/kernel';
import { ProfileMenuItem, ProfileStatus } from '../interfaces/profile';
import {ICustomElementViewModel, IPlatform} from "aurelia";

@customElement('blackcube-profile')
export class Profile implements ICustomElementViewModel
{
    public static readonly channel: string = 'Profile';

    @bindable({ mode: BindingMode.toView }) public avatar: string;
    @bindable({ mode: BindingMode.toView }) public initials: string;
    @bindable({ mode: BindingMode.toView }) public items: ProfileMenuItem[] = [];

    private menu: HTMLDivElement;

    private hasListener = false;

    constructor(
        @ILogger private readonly logger: ILogger,
        @IEventAggregator private readonly ea: IEventAggregator,
        @IPlatform private readonly platform: IPlatform,
        @INode private readonly element: HTMLElement
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
        if (this.items.length > 0) {
            this.hasListener = true;
            this.menu.style.display = 'none';
            this.menu.addEventListener('transitionend', this.onTransitionMenuEnded);
        }
    }

    public detaching()
    {
        this.logger.trace('Detaching');
        if (this.hasListener === true) {
            this.menu.removeEventListener('transitionend', this.onTransitionMenuEnded);
        }

    }

    public onToggle(evt: Event)
    {
        if (this.items.length > 0) {
            if (this.menu.classList.contains('opened')) {
                this.closeMenu(evt);
            } else if (this.menu.classList.contains('closed')) {
                this.openMenu(evt);
            }
        }
    }

    public onClickItem(evt: Event, index:number)
    {
        this.closeMenu(evt);
    }

    public openMenu(evt: Event)
    {
        this.ea.publish(Profile.channel, { status: ProfileStatus.OPENING});
        this.menu.style.display = 'inherit';
        this.platform.setTimeout(() => {
            this.menu.classList.remove('closed');
            this.menu.classList.add('opening', 'opened');
        },0);
    }

    public closeMenu(evt: Event)
    {
        this.ea.publish(Profile.channel, { status: ProfileStatus.CLOSING});
        this.menu.classList.remove('opened');
        this.menu.classList.add('closing', 'closed');
    }

    @watch((profile: Profile) => profile.items.length)
    public handleTransitionMenu(newValue, oldValue)
    {
        this.logger.debug('onChangeItems', newValue, oldValue);
        if (newValue > 0 && oldValue === 0) {
            this.platform.setTimeout(() => {
                this.menu.addEventListener('transitionend', this.onTransitionMenuEnded);
            });
            this.hasListener = true;
        } else if (newValue === 0 && oldValue > 0) {
            this.menu.removeEventListener('transitionend', this.onTransitionMenuEnded);
            this.hasListener = false;
        }
    }

    private onTransitionMenuEnded = (evt: TransitionEvent) => {
        if (this.menu.classList.contains('closing')) {
            this.menu.classList.remove('closing',  'opened');
            this.menu.style.display = 'none';
            this.ea.publish(Profile.channel, { status: ProfileStatus.CLOSED});
        } else if (this.menu.classList.contains('opening')) {
            this.menu.classList.remove('opening', 'closed');
            this.ea.publish(Profile.channel, { status: ProfileStatus.OPENED});
        }
    };
}