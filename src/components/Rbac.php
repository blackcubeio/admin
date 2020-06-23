<?php
/**
 * Rbac.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\components
 */

namespace blackcube\admin\components;

use yii\helpers\Inflector;

/**
 * Class Rbac
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\components
 */
class Rbac
{
    public const PERMISSION_CATEGORY_CREATE = 'CATEGORY:CREATE';
    public const PERMISSION_CATEGORY_DELETE = 'CATEGORY:DELETE';
    public const PERMISSION_CATEGORY_UPDATE = 'CATEGORY:UPDATE';
    public const PERMISSION_CATEGORY_VIEW = 'CATEGORY:VIEW';
    public const ROLE_CATEGORY_MANAGER = 'CATEGORY:MANAGER';

    public const PERMISSION_TAG_CREATE = 'TAG:CREATE';
    public const PERMISSION_TAG_DELETE = 'TAG:DELETE';
    public const PERMISSION_TAG_UPDATE = 'TAG:UPDATE';
    public const PERMISSION_TAG_VIEW = 'TAG:VIEW';
    public const ROLE_TAG_MANAGER = 'TAG:MANAGER';

    public const PERMISSION_NODE_CREATE = 'NODE:CREATE';
    public const PERMISSION_NODE_DELETE = 'NODE:DELETE';
    public const PERMISSION_NODE_UPDATE = 'NODE:UPDATE';
    public const PERMISSION_NODE_VIEW = 'NODE:VIEW';
    public const ROLE_NODE_MANAGER = 'NODE:MANAGER';

    public const PERMISSION_COMPOSITE_CREATE = 'COMPOSITE:CREATE';
    public const PERMISSION_COMPOSITE_DELETE = 'COMPOSITE:DELETE';
    public const PERMISSION_COMPOSITE_UPDATE = 'COMPOSITE:UPDATE';
    public const PERMISSION_COMPOSITE_VIEW = 'COMPOSITE:VIEW';
    public const ROLE_COMPOSITE_MANAGER = 'COMPOSITE:MANAGER';

    public const PERMISSION_BLOCTYPE_CREATE = 'BLOCTYPE:CREATE';
    public const PERMISSION_BLOCTYPE_DELETE = 'BLOCTYPE:DELETE';
    public const PERMISSION_BLOCTYPE_UPDATE = 'BLOCTYPE:UPDATE';
    public const PERMISSION_BLOCTYPE_VIEW = 'BLOCTYPE:VIEW';
    public const ROLE_BLOCTYPE_MANAGER = 'BLOCTYPE:MANAGER';

    public const PERMISSION_TYPE_CREATE = 'TYPE:CREATE';
    public const PERMISSION_TYPE_DELETE = 'TYPE:DELETE';
    public const PERMISSION_TYPE_UPDATE = 'TYPE:UPDATE';
    public const PERMISSION_TYPE_VIEW = 'TYPE:VIEW';
    public const ROLE_TYPE_MANAGER = 'TYPE:MANAGER';

    public const PERMISSION_PARAMETER_CREATE = 'PARAMETER:CREATE';
    public const PERMISSION_PARAMETER_DELETE = 'PARAMETER:DELETE';
    public const PERMISSION_PARAMETER_UPDATE = 'PARAMETER:UPDATE';
    public const PERMISSION_PARAMETER_VIEW = 'PARAMETER:VIEW';
    public const ROLE_PARAMETER_MANAGER = 'PARAMETER:MANAGER';

    public const PERMISSION_MENU_CREATE = 'MENU:CREATE';
    public const PERMISSION_MENU_DELETE = 'MENU:DELETE';
    public const PERMISSION_MENU_UPDATE = 'MENU:UPDATE';
    public const PERMISSION_MENU_VIEW = 'MENU:VIEW';
    public const ROLE_MENU_MANAGER = 'MENU:MANAGER';

    public const ROLE_SITE_MANAGER = 'SITE:MANAGER';
    public const PERMISSION_SITE_PREVIEW = 'SITE:PREVIEW';
    public const PERMISSION_SITE_DASHBOARD = 'SITE:DASHBOARD';
    public const PERMISSION_SITE_SEARCH = 'SITE:SEARCH';

    public const PERMISSION_USER_CREATE = 'USER:CREATE';
    public const PERMISSION_USER_DELETE = 'USER:DELETE';
    public const PERMISSION_USER_UPDATE = 'USER:UPDATE';
    public const PERMISSION_USER_VIEW = 'USER:VIEW';
    public const ROLE_USER_MANAGER = 'USER:MANAGER';

    public const PERMISSION_SLUG_DELETE = 'SLUG:DELETE';
    public const PERMISSION_SLUG_UPDATE = 'SLUG:UPDATE';
    public const PERMISSION_SLUG_VIEW = 'SLUG:VIEW';
    public const ROLE_SLUG_MANAGER = 'SLUG:MANAGER';

    public const PERMISSION_PLUGIN_DELETE = 'PLUGIN:DELETE';
    public const PERMISSION_PLUGIN_UPDATE = 'PLUGIN:UPDATE';
    public const PERMISSION_PLUGIN_VIEW = 'PLUGIN:VIEW';
    public const ROLE_PLUGIN_MANAGER = 'PLUGIN:MANAGER';

    public const ROLE_ADMIN = 'ADMIN';

    /**
     * @param string $permission
     * @return string
     */
    public static function extractPermission($permission)
    {
        if (strpos($permission, ':') !== false) {
            list($type, $name) = explode(':', $permission);
        } else {
            $name = $permission;
        }
        return $name;
    }

    /**
     * @param string $role
     * @return string
     */
    public static function extractRole($role)
    {
        if (strpos($role, ':') !== false) {
            list($name, $type) = explode(':', $role);
        } else {
            $name = $role;
        }
        return $name;
    }

    /**
     * @param string $item
     * @return string
     */
    public static function rbac2Id($item)
    {
        $item = strtolower(str_replace(':', '_', $item));
        $item = Inflector::camelize($item);
        return Inflector::camel2id($item);
    }

    /**
     * @param string $item
     * @return string
     */
    public static function rbac2Name($item)
    {
        $item = strtolower(str_replace(':', '_', $item));
        return Inflector::camelize($item);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function name2Rbac($name)
    {
        $name = Inflector::titleize($name, true);
        return strtoupper(str_replace(' ', ':', $name));
    }
}
