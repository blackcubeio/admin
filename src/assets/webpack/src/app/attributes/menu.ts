import {
    customAttribute,
    IEventAggregator,
    ILogger,
    ICustomAttributeViewModel,
    ICustomElementViewModel,
    IPlatform,
    IDisposable,
    INode,
    resolve
} from 'aurelia';
import { MenuEvent, MenuEventType, MenuStatus } from '../interfaces/menu';
import {IStorageService} from "../services/storage-service";

@customAttribute('blackcube-menu')
export class Menu implements ICustomAttributeViewModel
{
    private menuMobile: HTMLDivElement;
    private menuMobileCloseBtn: HTMLButtonElement;
    private menuMobileClosePanel: HTMLDivElement;
    private menuMobileOffcanvas: HTMLDivElement;
    private menuMobileOverlay: HTMLDivElement;
    private menuDesktop: HTMLDivElement;

    private expanders: NodeListOf<HTMLButtonElement>;
    private desktopExpanders: NodeListOf<HTMLButtonElement>;

    private menuMobileSubscriber: IDisposable;

    private isMobile: boolean;

    public static channel = 'Menu';

    public constructor(
        private readonly logger: ILogger = resolve(ILogger).scopeTo('Menu'),
        private readonly ea: IEventAggregator = resolve(IEventAggregator),
        private readonly platform: IPlatform = resolve(IPlatform),
        private readonly storageService: IStorageService = resolve(IStorageService),
        private readonly element: HTMLElement = resolve(INode) as HTMLElement,
    )
    {
    }
    public attaching()
    {
        this.logger.trace('Attaching');
        // this.menuMobile = this.element.querySelector('.menu-mobile') as HTMLDivElement;
        if (this.element.classList.contains('menu-mobile')) {
            this.isMobile = true;
            this.element.style.display = 'none';
            this.menuMobileCloseBtn = this.element.querySelector('[data-ref=close]') as HTMLButtonElement;
            this.menuMobileClosePanel = this.element.querySelector('[data-ref=closepanel]') as HTMLDivElement;
            this.menuMobileOffcanvas = this.element.querySelector('[data-ref=offcanvas]') as HTMLDivElement;
            this.menuMobileOverlay = this.element.querySelector('[data-ref=overlay]') as HTMLDivElement;
            this.menuMobileSubscriber = this.ea.subscribe(Menu.channel, this.onMenuEvent)

        } else if (this.element.classList.contains('menu-desktop')) {
            this.isMobile = false;
            this.menuDesktop = this.element.querySelector('.menu-desktop') as HTMLDivElement;

        }
        this.expanders = this.element.querySelectorAll('.navbar-item-btn');
    }

    public attached()
    {
        this.logger.trace('Attached');
        if (this.isMobile && this.menuMobileCloseBtn) {
            this.menuMobileCloseBtn.addEventListener('click', this.onCloseMobileMenu);
        }
        const currentSections:NodeListOf<HTMLElement> = this.element.querySelectorAll('[data-blackcube-section]');
        currentSections.forEach((section:HTMLElement) => {
            const currentSectionData = section.dataset.blackcubeSection;
            if (currentSectionData) {
                let opened = this.storageService.getSectionOpened('menu', currentSectionData);
                if (opened) {
                    section.classList.add('expanded');
                } else {
                    section.classList.remove('expanded');
                }
            }
        });
        this.expanders.forEach((expander, index) => {
            expander.addEventListener('click', this.onClickExpander);
        });
    }

    public detaching()
    {
        this.logger.trace('Detached');
        this.expanders.forEach((expander, index) => {
            expander.removeEventListener('click', this.onClickExpander);
        });
        if (this.isMobile) {
            this.menuMobileCloseBtn.removeEventListener('click', this.onCloseMobileMenu);
        }
    }

    private onClickExpander = (evt: Event) => {
        const clickedNode = evt.currentTarget as HTMLElement;
        const parentNode = clickedNode.closest('.navbar-item') as HTMLDivElement;
        const currentSectionData = parentNode.dataset.blackcubeSection;
        if (parentNode.classList.contains('expanded')) {
            parentNode.classList.remove('expanded');
            if(currentSectionData) {
                this.storageService.setSectionClosed('menu', currentSectionData);
            }
        } else {
            parentNode.classList.add('expanded');
            if(currentSectionData) {
                this.storageService.setSectionOpened('menu', currentSectionData);
            }
        }
    };

    private onMenuEvent = (event: MenuEvent) => {
        if (this.isMobile) {
            if (event.type === MenuEventType.OPEN) {
                // this.logger.debug('Should open menu');
                this.openWithTransition();
            } else if (event.type === MenuEventType.CLOSE) {
                // this.logger.debug('Should close menu');
                this.closeWithTransition();
            }
        }
    };

    private onCloseMobileMenu = (evt: Event) => {
        evt.preventDefault();
        this.ea.publish(Menu.channel, {type: MenuEventType.CLOSE});
        this.logger.trace('Close mobile menu');
    };

    private openWithTransition(): Promise<boolean>
    {

        this.element.style.display = 'inherit';
        this.ea.publish(Menu.channel, {
            status: MenuStatus.OPENING
        });
        const animationPromise = new Promise<boolean>((resolve) => {
            setTimeout(() => {
                resolve(true);
            });
        });
        return animationPromise
            .then((status) => {
                const animationPromises:Promise<boolean>[] = [];
                const overlayPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileOverlay.classList.contains('opening')) {
                            this.menuMobileOverlay.classList.remove('opening', 'closed');
                            this.menuMobileOverlay.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileOverlay.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileOverlay.classList.remove('closed');
                    this.menuMobileOverlay.classList.add('opening', 'opened');
                });
                animationPromises.push(overlayPromise);
                const offcanvasPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileOffcanvas.classList.contains('opening')) {
                            this.menuMobileOffcanvas.classList.remove('opening', 'closed');
                            this.menuMobileOffcanvas.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileOffcanvas.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileOffcanvas.classList.remove('closed');
                    this.menuMobileOffcanvas.classList.add('opening', 'opened');
                });
                animationPromises.push(offcanvasPromise);
                const closepanelPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileClosePanel.classList.contains('opening')) {
                            this.menuMobileClosePanel.classList.remove('opening', 'closed');
                            this.menuMobileClosePanel.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileClosePanel.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileClosePanel.classList.remove('closed');
                    this.menuMobileClosePanel.classList.add('opening', 'opened');
                });
                animationPromises.push(closepanelPromise);
                return Promise.all(animationPromises);
            })
            .then((result) => {
                this.ea.publish(Menu.channel, {
                    status: MenuStatus.OPENED
                });
                return result.reduce((acc, el) => {
                    return el && acc;
                }, true)
            });
    }

    private closeWithTransition(): Promise<boolean>
    {
        this.ea.publish(Menu.channel, {
            status: MenuStatus.CLOSING
        });
        const animationPromise = new Promise<boolean>((resolve) => {
            setTimeout(() => {
                resolve(true);
            });
        });
        return animationPromise
            .then((status) => {
                const animationPromises:Promise<boolean>[] = [];
                const overlayPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileOverlay.classList.contains('closing')) {
                            this.menuMobileOverlay.classList.remove('closing', 'opened');
                            this.menuMobileOverlay.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileOverlay.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileOverlay.classList.remove('opened');
                    this.menuMobileOverlay.classList.add('closing', 'closed');
                });
                animationPromises.push(overlayPromise);
                const offcanvasPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileOffcanvas.classList.contains('closing')) {
                            this.menuMobileOffcanvas.classList.remove('closing', 'opened');
                            this.menuMobileOffcanvas.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileOffcanvas.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileOffcanvas.classList.remove('opened');
                    this.menuMobileOffcanvas.classList.add('closing', 'closed');
                });
                animationPromises.push(offcanvasPromise);
                const closepanelPromise = new Promise<boolean>((resolve) => {
                    const endWrapperTransition = (evt: TransitionEvent) => {
                        if (this.menuMobileClosePanel.classList.contains('closing')) {
                            this.menuMobileClosePanel.classList.remove('closing', 'opened');
                            this.menuMobileClosePanel.removeEventListener('transitionend', endWrapperTransition);
                            resolve(true);
                        }
                    };
                    this.menuMobileClosePanel.addEventListener('transitionend', endWrapperTransition);
                    this.menuMobileClosePanel.classList.remove('opened');
                    this.menuMobileClosePanel.classList.add('closing', 'closed');
                });
                animationPromises.push(closepanelPromise);
                return Promise.all(animationPromises);
            })
            .then((result) => {
                this.ea.publish(Menu.channel, {
                    status: MenuStatus.CLOSED
                });
                this.element.style.display = 'none';
                return result.reduce((acc, el) => {
                    return el && acc;
                }, true)
            })
    }
}