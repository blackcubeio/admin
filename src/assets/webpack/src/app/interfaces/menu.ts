export enum MenuEventType {
    OPEN,
    CLOSE
}
export interface MenuEvent {
    type: MenuEventType
}
export enum MenuStatus {
    OPENING,
    OPENED,
    CLOSING,
    CLOSED
}
