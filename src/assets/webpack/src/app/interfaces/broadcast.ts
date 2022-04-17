export interface BroadcastElementData
{
    type: string;
    id: string|number;
}

export enum BroadcastElementEventType {
    CREATE = 'create',
    UPDATE = 'update',
    DELETE = 'delete',
    ACTIVATE = 'activate',
    DEACTIVATE = 'deactivate'
}

export interface BroadcastElementEvent {
    type: BroadcastElementEventType;
    data?: BroadcastElementData;
}
export class Broadcast {
    public static channel = 'general';
}