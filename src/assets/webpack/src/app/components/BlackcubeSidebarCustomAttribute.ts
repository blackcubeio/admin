
import {DOM, inject, noView, bindable, bindingMode, LogManager, ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind, View} from 'aurelia-framework';
import {Logger} from "aurelia-logging";
import {EventAggregator} from 'aurelia-event-aggregator';
import {StorageService} from "../services/StorageService";

@inject(DOM.Element, StorageService)
class BlackcubeSidebarCustomAttribute implements ComponentCreated, ComponentBind, ComponentAttached, ComponentDetached, ComponentUnbind {
    private element:HTMLElement;
    private storageService:StorageService;
    private logger:Logger = LogManager.getLogger('components.BlackcubeSidebar');

    public constructor(element:HTMLElement, storageService:StorageService) {
        this.element = element;
        this.storageService = storageService;
        this.logger.debug('Constructor');
    }

    public created(owningView: View, myView: View): void {
        this.logger.debug('Created');
    }

    public bind(bindingContext: any, overrideContext: any): void {
        this.logger.debug('Bind');
    }

    public attached(): void {
        let currentSections:NodeListOf<HTMLElement> = this.element.querySelectorAll('[data-blackcube-section]');
        currentSections.forEach((element:HTMLElement) => {
            let currentSection = element.dataset.blackcubeSection;
            if (currentSection) {
                let opened = this.storageService.getSectionOpened('menu', currentSection);
                let nexNode = <HTMLElement>element.nextElementSibling;
                let arrow = <HTMLElement>element.querySelector('i.arrow');
                if (opened) {
                    if (nexNode) {
                        nexNode.classList.remove('hidden');
                    }
                    if (arrow) {
                        arrow.classList.remove('fa-angle-right')
                        arrow.classList.add('fa-angle-down')
                    }
                } else if (nexNode) {
                    nexNode.classList.add('hidden');
                    if (arrow) {
                        arrow.classList.remove('fa-angle-down')
                        arrow.classList.add('fa-angle-right')
                    }
                }
            }
        });
        this.element.addEventListener('click', this.onDelegateClick);
        this.logger.debug('Attached');
    }

    public detached(): void {
        this.element.removeEventListener('click', this.onDelegateClick);
        this.logger.debug('Detached');
    }

    public unbind(): void {
        this.logger.debug('Unbind');
    }

    protected onDelegateClick = (evt:Event) => {
        if (evt.target) {
            //@ts-ignore
            let currentButton = <HTMLElement>evt.target.closest('[data-blackcube-section]');
            if (currentButton && this.element.contains(currentButton)) {
                this.logger.debug('delegateClick');
                let currentSection = currentButton.dataset.blackcubeSection;
                if (currentSection) {
                    let opened = this.storageService.getSectionOpened('menu', currentSection);
                    let nexNode = currentButton.nextElementSibling;
                    let arrow = <HTMLElement>currentButton.querySelector('i.arrow');
                    if (opened) {
                        this.storageService.setSectionClosed('menu', currentSection);
                        if (nexNode) {
                            nexNode.classList.add('hidden');
                        }
                        if (arrow) {
                            arrow.classList.remove('fa-angle-down')
                            arrow.classList.add('fa-angle-right')
                        }
                    } else if (nexNode) {
                        this.storageService.setSectionOpened('menu', currentSection);
                        nexNode.classList.remove('hidden');
                        if (arrow) {
                            arrow.classList.remove('fa-angle-right')
                            arrow.classList.add('fa-angle-down')
                        }
                    }
                }
            }
        }
    };

}

export {BlackcubeSidebarCustomAttribute}
