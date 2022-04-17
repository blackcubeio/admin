export enum ProfileStatus {
    OPENED,
    OPENING,
    CLOSED,
    CLOSING
}
export interface ProfileEvent {
    status: ProfileStatus;
}
export interface ProfileMenuItem {
    label: string;
    url: string;
    active: boolean;
}
