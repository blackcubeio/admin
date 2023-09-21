import { NotificationStatus } from '../interfaces/notification';


export interface TransitionOuter
{
    element: HTMLElement;
    beforeDisplayStyle?: string;
    afterDisplayStyle?: string;
    startingCallback?: Function;
    endingCallback?: Function;
}
export interface TransitionInterface
{
    element: HTMLElement;
    from: string[];
    to: string[];
    transition: string[];
}

export function transitionWithPromise(outer: TransitionOuter, transitions: TransitionInterface[]): Promise<boolean>
{
    // XXX beforeStart XXX send event this.ea.publish(Alert.channel, {status: AlertStatus.OPENING})
    // stack everything to avoid glitches
    const animationPromise = new Promise<boolean>((resolve) => {
        if (outer.startingCallback) {
            outer.startingCallback();
        }
        if (outer.beforeDisplayStyle) {
            outer.element.style.display = outer.beforeDisplayStyle as string;
        }
        setTimeout(() => {
            resolve(true);
            }, 10);
    });
    return animationPromise
        .then((status) => {
            const animationPromises: Promise<boolean>[] = [Promise.resolve(true)];
                transitions.forEach((transition) => {
                    const transitionPromise = new Promise<boolean>((resolve) => {
                        const endingTransition = (evt: TransitionEvent) => {
                            // const firstTransitionClass = transition.transition[0];
                            // if (transition.element.classList.contains(firstTransitionClass)) {
                            transition.element.removeEventListener('transitionend', endingTransition);
                            transition.transition.forEach((transitionClass) => {
                                transition.element.classList.remove(transitionClass);
                            });
                            resolve(true);
                            // }
                        }
                        transition.element.addEventListener('transitionend', endingTransition);
                        transition.from.forEach((transitionClass) => {
                            transition.element.classList.remove(transitionClass);
                        });
                        transition.to.forEach((transitionClass) => {
                            transition.element.classList.add(transitionClass);
                        });
                        transition.transition.forEach((transitionClass) => {
                            transition.element.classList.add(transitionClass);
                        });
                    });
                    animationPromises.push(transitionPromise);
                });
            return Promise.all(animationPromises);
            // from 'closed'
            // to 'opened'
            // transition 'opening'
        })
        .then((animationStatuses) => {
            const status = animationStatuses.reduce((accumulator, status) => {
                return accumulator && status;
            }, true);
            return new Promise<boolean>(resolve => {
                setTimeout(() => {
                    resolve(status);
                })
            });
        })
        .then((status) => {
            const finalPromises: Promise<boolean>[] = [];
            finalPromises.push(Promise.resolve(status));
            transitions.forEach((transition) => {
                transition.transition.forEach((transitionClass) => {
                    // clean up transition stuff
                    finalPromises.push(new Promise<boolean>((resolve) => {
                        transition.element.classList.remove(transitionClass);
                        resolve(true);
                    }));
                });
            });
            return Promise.all(finalPromises);
        })
        .then((status) => {
            if (outer.afterDisplayStyle) {
                outer.element.style.display = outer.afterDisplayStyle as string;
            }
            if (outer.endingCallback) {
                outer.endingCallback();
            }
            return new Promise<boolean>((resolve) => {
                setTimeout(() => {
                    resolve(true);
                }, 10);
            });
            // return status;
        });
}
