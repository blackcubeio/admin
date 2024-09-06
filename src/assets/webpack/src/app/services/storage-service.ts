import {DI} from 'aurelia';

export const IStorageService =
    DI.createInterface<IStorageService>('IStorageService', (x) =>
        x.singleton(StorageService)
    );
export interface IStorageService extends StorageService {}
class StorageService
{
    public getElementOpened(elementType:string, elementSubData:string, elementId: string): boolean
    {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            const storageStatus = localStorage.getItem('admin:element:'+elementType+'-'+elementId+':'+elementSubData+':opened');
            return storageStatus === '1';
        }
        return false;

    }
    public setElementOpened(elementType:string, elementSubData:string, elementId: string): void
    {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.setItem('admin:element:'+elementType+'-'+elementId+':'+elementSubData+':opened', '1');
        }

    }
    public setElementClosed(elementType:string, elementSubData:string, elementId: string): void
    {
        if (elementId !== '' && elementSubData !== '' && elementType !== '') {
            localStorage.removeItem('admin:element:'+elementType+'-'+elementId+':'+elementSubData+':opened');
        }

    }
    public getSectionOpened(elementType:string, elementId: string): boolean
    {
        if (elementId !== '' && elementType !== '') {
            const storageStatus = localStorage.getItem('admin:section:'+elementType+'-'+elementId+':opened');
            return storageStatus === '1';
        }
        return false;

    }
    public setSectionOpened(elementType:string, elementId: string): void
    {
        if (elementId !== '' && elementType !== '') {
            localStorage.setItem('admin:section:'+elementType+'-'+elementId+':opened', '1');
        }

    }
    public setSectionClosed(elementType:string, elementId: string): void
    {
        if (elementId !== '' && elementType !== '') {
            localStorage.removeItem('admin:section:'+elementType+'-'+elementId+':opened');
        }

    }
    public getElementSlugOpened(elementId:string):boolean
    {
        if (elementId !== '') {
            const storageStatus = localStorage.getItem('admin:element:'+elementId+':slug:opened');
            return storageStatus === '1';
        }
        return false;
    }

    public setElementSlugOpened(elementId:string)
    {
        if (elementId !== '') {
            localStorage.setItem('admin:element:'+elementId+':slug:opened', '1');
        }
    }

    public setElementSlugClosed(elementId:string)
    {
        if (elementId !== '') {
            localStorage.removeItem('admin:element:'+elementId+':slug:opened');
        }
    }
}

export {StorageService}
