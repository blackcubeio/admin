<?php
/**
 * PluginAdminHookInterface.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */

namespace blackcube\admin\interfaces;

use blackcube\core\interfaces\PluginHookInterface;

/**
 * Interface PluginAdminHookInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\core\interfaces
 */
interface PluginAdminHookInterface extends PluginHookInterface {
    const PLUGIN_HOOK_WIDGET_COMPOSITE_LIST_HEAD = 'pluginAdminHookWidgetCompositeListHead';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_LIST_BEFORE_LIST = 'pluginAdminHookWidgetCompositeListBeforeList';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_LIST_AFTER_LIST = 'pluginAdminHookWidgetCompositeListAfterList';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_HEAD = 'pluginAdminHookWidgetCompositeCreateHead';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_BEFORE_BLOCS = 'pluginAdminHookWidgetCompositeCreateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_TAIL = 'pluginAdminHookWidgetCompositeCreateTail';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_HEAD = 'pluginAdminHookWidgetCompositeUpdateHead';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_BEFORE_BLOCS = 'pluginAdminHookWidgetCompositeUpdateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_TAIL = 'pluginAdminHookWidgetCompositeUpdateTail';

    const PLUGIN_HOOK_WIDGET_NODE_LIST_HEAD = 'pluginAdminHookWidgetNodeListHead';
    const PLUGIN_HOOK_WIDGET_NODE_LIST_BEFORE_LIST = 'pluginAdminHookWidgetNodeListBeforeList';
    const PLUGIN_HOOK_WIDGET_NODE_LIST_AFTER_LIST = 'pluginAdminHookWidgetNodeListAfterList';
    const PLUGIN_HOOK_WIDGET_NODE_CREATE_HEAD = 'pluginAdminHookWidgetNodeCreateHead';
    const PLUGIN_HOOK_WIDGET_NODE_CREATE_BEFORE_BLOCS = 'pluginAdminHookWidgetNodeCreateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_NODE_CREATE_TAIL = 'pluginAdminHookWidgetNodeCreateTail';
    const PLUGIN_HOOK_WIDGET_NODE_UPDATE_HEAD = 'pluginAdminHookWidgetNodeUpdateHead';
    const PLUGIN_HOOK_WIDGET_NODE_UPDATE_BEFORE_BLOCS = 'pluginAdminHookWidgetNodeUpdateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_NODE_UPDATE_TAIL = 'pluginAdminHookWidgetNodeUpdateTail';

    const PLUGIN_HOOK_WIDGET_CATEGORY_LIST_HEAD = 'pluginAdminHookWidgetCategoryListHead';
    const PLUGIN_HOOK_WIDGET_CATEGORY_LIST_BEFORE_LIST = 'pluginAdminHookWidgetCategoryListBeforeList';
    const PLUGIN_HOOK_WIDGET_CATEGORY_LIST_AFTER_LIST = 'pluginAdminHookWidgetCategoryListAfterList';
    const PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_HEAD = 'pluginAdminHookWidgetCategoryCreateHead';
    const PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_BEFORE_BLOCS = 'pluginAdminHookWidgetCategoryCreateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_TAIL = 'pluginAdminHookWidgetCategoryCreateTail';
    const PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_HEAD = 'pluginAdminHookWidgetCategoryUpdateHead';
    const PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_BEFORE_BLOCS = 'pluginAdminHookWidgetCategoryUpdateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_TAIL = 'pluginAdminHookWidgetCategoryUpdateTail';

    const PLUGIN_HOOK_WIDGET_TAG_LIST_HEAD = 'pluginAdminHookWidgetTagListHead';
    const PLUGIN_HOOK_WIDGET_TAG_LIST_BEFORE_LIST = 'pluginAdminHookWidgetTagListBeforeList';
    const PLUGIN_HOOK_WIDGET_TAG_LIST_AFTER_LIST = 'pluginAdminHookWidgetTagListAfterList';
    const PLUGIN_HOOK_WIDGET_TAG_CREATE_HEAD = 'pluginAdminHookWidgetTagCreateHead';
    const PLUGIN_HOOK_WIDGET_TAG_CREATE_BEFORE_BLOCS = 'pluginAdminHookWidgetTagCreateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_TAG_CREATE_TAIL = 'pluginAdminHookWidgetTagCreateTail';
    const PLUGIN_HOOK_WIDGET_TAG_UPDATE_HEAD = 'pluginAdminHookWidgetTagUpdateHead';
    const PLUGIN_HOOK_WIDGET_TAG_UPDATE_BEFORE_BLOCS = 'pluginAdminHookWidgetTagUpdateBeforeBlocs';
    const PLUGIN_HOOK_WIDGET_TAG_UPDATE_TAIL = 'pluginAdminHookWidgetTagUpdateTail';

}
