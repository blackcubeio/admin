import { FrameworkConfiguration, PLATFORM } from 'aurelia-framework';

export function configure(configure: FrameworkConfiguration) {
    configure.globalResources([
        PLATFORM.moduleName('components/BlackcubeSchemaEditorCustomElement'),
        PLATFORM.moduleName('components/BlackcubeToggleSlugCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeBlocsCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeCompositesCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeAttachModalCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeFileCustomElement'),
        PLATFORM.moduleName('components/BlackcubeChoicesCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubePieCustomElement'),
        PLATFORM.moduleName('components/BlackcubeControllerActionCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeToggleDependenciesCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeToggleElementCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeSearchCompositeCustomElement'),
        PLATFORM.moduleName('components/BlackcubeRbacCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeSidebarCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeEditorJsCustomElement'),
        PLATFORM.moduleName('components/BlackcubeAjaxifyCustomAttribute'),
        PLATFORM.moduleName('components/BlackcubeUrlGeneratorCustomAttribute')
    ]);
}
