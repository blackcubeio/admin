import { FrameworkConfiguration, PLATFORM } from 'aurelia-framework';

export function configure(configure: FrameworkConfiguration) {
    configure.globalResources([
        PLATFORM.moduleName('components/SchemaEditorCustomElement'),
        PLATFORM.moduleName('components/ToggleSlugCustomAttribute'),
        PLATFORM.moduleName('components/HtmlLoaderCustomAttribute'),
        PLATFORM.moduleName('components/LoaderDoneCustomAttribute'),
        PLATFORM.moduleName('components/ManageBlocsCustomAttribute'),
        PLATFORM.moduleName('components/AttachModalCustomAttribute'),
        PLATFORM.moduleName('components/AjaxLinkManagerCustomAttribute'),
        PLATFORM.moduleName('components/ResumableFileCustomElement')
    ]);
}
