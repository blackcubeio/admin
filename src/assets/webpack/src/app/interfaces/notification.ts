export enum NotificationStatus {
    OPENING,
    OPENED,
    CLOSING,
    CLOSED,
    REMOVED
}
export enum NotificationType {
    CHECK= 'check',
    EXCLAMATION = 'exclamation',
    INFORMATION = 'information'
}
export interface NotificationEvent {
    status: NotificationStatus;
    index: number
}
export interface NotificationData
{
    type: NotificationType,
    title: string,
    content: string,
    duration?: number
}

export enum NotificationCenterEventType {
    CREATE,
    REMOVE_ALL
}

export interface NotificationCenterEvent {
    type: NotificationCenterEventType,
    notification?: NotificationData
}