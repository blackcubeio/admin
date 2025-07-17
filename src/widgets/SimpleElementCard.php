<?php
/**
 * SimpleElementCard.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\widgets;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\Administrator;
use blackcube\admin\Module;
use blackcube\core\models\BlocType;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Menu;
use blackcube\core\models\Node;
use blackcube\core\models\Parameter;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use yii\base\NotSupportedException;
use yii\base\Widget;

/**
 * Widget SimpleElementCard
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class SimpleElementCard extends Widget
{
    /**
     * @var Node|Composite|Category|Tag|Slug
     */
    public $element;

    /**
     * @var string
     */
    public $elementType;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        if ($this->element instanceof Administrator) {
            $controller = 'user';
            $type = Module::t('widgets', 'Users');
            $icon = 'outline/users';
            $title = $this->element->email;
            $info = $this->element->firstname . ' ' . $this->element->lastname;
            $updatePermission = Rbac::PERMISSION_USER_UPDATE;
            $deletePermission = Rbac::PERMISSION_USER_DELETE;
        } elseif ($this->element instanceof Type) {
            $controller = 'type';
            $type = Module::t('widgets', 'Types');
            $icon = 'outline/template';
            $title = $this->element->name;
            $info = Module::t('widgets', 'Route: {route}', ['route' => ($this->element->route === null) ? Module::t('widgets', 'no route') : $this->element->route]);
            $updatePermission = Rbac::PERMISSION_TYPE_UPDATE;
            $deletePermission = Rbac::PERMISSION_TYPE_DELETE;
        } elseif ($this->element instanceof BlocType) {
            $controller = 'bloc-type';
            $type = Module::t('widgets', 'Bloc types');
            $icon = 'outline/cube';
            $title = $this->element->name;
            $info = '';
            $updatePermission = Rbac::PERMISSION_BLOCTYPE_UPDATE;
            $deletePermission = Rbac::PERMISSION_BLOCTYPE_DELETE;
        } elseif ($this->element instanceof Parameter) {
            $controller = 'parameter';
            $type = Module::t('widgets', 'Parameters');
            $icon = 'outline/puzzle';
            $title = $this->element->name;
            $info = $this->element->domain;
            $updatePermission = Rbac::PERMISSION_PARAMETER_UPDATE;
            $deletePermission = Rbac::PERMISSION_PARAMETER_DELETE;
        } elseif ($this->element instanceof Menu) {
            $controller = 'menu';
            $type = Module::t('widgets', 'Menus');
            $icon = 'outline/view-list';
            $title = $this->element->name;
            $info = (empty($this->element->host) ? '' : $this->element->host.' - ').$this->element->language->name;'';

            $updatePermission = Rbac::PERMISSION_MENU_UPDATE;
            $deletePermission = Rbac::PERMISSION_MENU_DELETE;
        } elseif ($this->element instanceof Language) {
            $controller = 'language';
            $type = Module::t('widgets', 'Languages');
            $icon = 'outline/flag';
            $title = $this->element->name;
            $info = $this->element->main ? Module::t('widgets', 'Primary') : ($this->element->mainLanguage->name ?? Module::t('widgets', 'Unknown'));
            $updatePermission = Rbac::PERMISSION_LANGUAGE_UPDATE;
            $deletePermission = Rbac::PERMISSION_LANGUAGE_DELETE;
        } else {
            throw new NotSupportedException('Element type "'.get_class($this->element).'" is not supported');
        }
        return $this->render('simple-element-card', [
            'title' => $title,
            'info' => $info,
            'type' => $type,
            'controller' => $controller,
            'icon' => $icon,
            'updatePermission' => $updatePermission,
            'deletePermission' => $deletePermission,
            'element' => $this->element,
            'elementType' => $this->elementType,
        ]);
    }
}
