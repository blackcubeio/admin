export enum OverlayStatus {
    OPENING,
    OPENED,
    CLOSING,
    CLOSED,
    REMOVED
}

export enum OverlayEventType {
    OPEN,
    CLOSE
}

export interface OverlayData {
    title: string;
    abstract: string;
    cancelTitle?: string;
    actionTitle?: string;
    url?: string;
    cancel?: Function;
    action?: Function;
}

export interface OverlayEvent {
    type: OverlayEventType;
    overlay?: OverlayData;
}