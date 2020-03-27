class StorageService
{
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
