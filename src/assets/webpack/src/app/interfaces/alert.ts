export enum AlertStatus {
    OPENING,
    OPENED,
    CLOSING,
    CLOSED,
    REMOVED
}
export enum AlertType {
    CHECK= 'check',
    EXCLAMATION = 'exclamation',
    QUESTION = 'question'
}
export interface AlertData {
    type: AlertType,
    actionTitle?: string,
    cancelTitle?: string,
    contentUrl: string,
    cancel?: Function,
    action?: Function
}

export enum AlertEventType {
    OPEN,
    CLOSE
}
export interface AlertEvent {
    type: AlertEventType,
    alert?: AlertData
}
