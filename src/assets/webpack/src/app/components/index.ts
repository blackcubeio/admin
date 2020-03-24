import { FrameworkConfiguration, PLATFORM } from 'aurelia-framework';

export function configure(configure: FrameworkConfiguration) {
    configure.globalResources([
        PLATFORM.moduleName('components/SchemaEditorCustomElement'),
        PLATFORM.moduleName('components/ToggleBlocCustomAttribute'),
        PLATFORM.moduleName('components/HtmlLoaderCustomAttribute'),
        PLATFORM.moduleName('components/LoaderDoneCustomAttribute'),
        PLATFORM.moduleName('components/ManageBlocsCustomAttribute')
    ]);
}
