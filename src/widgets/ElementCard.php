<?php
/**
 * ElementCard.php
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
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\base\Widget;

/**
 * Widget ElementCard
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class ElementCard extends Widget
{
    /**
     * @var Node|Composite|Category|Tag|Slug
     */
    public $element;

    /**
     * @var bool
     */
    public $tree = false;

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        if ($this->element instanceof Node) {
            $controller = 'node';
            $type = Module::t('widgets', 'Nodes');
            $icon = 'outline/folder';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_NODE_UPDATE;
            $deletePermission = Rbac::PERMISSION_NODE_DELETE;
            $exportPermission = Rbac::PERMISSION_NODE_EXPORT;
        } elseif ($this->element instanceof Composite) {
            $type = Module::t('widgets', 'Composites');
            $controller = 'composite';
            $icon = 'outline/document-text';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_COMPOSITE_UPDATE;
            $deletePermission = Rbac::PERMISSION_COMPOSITE_DELETE;
            $exportPermission = Rbac::PERMISSION_COMPOSITE_EXPORT;
        } elseif ($this->element instanceof Category) {
            $type = Module::t('widgets', 'Categories');
            $controller = 'category';
            $icon = 'outline/color-swatch';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_CATEGORY_UPDATE;
            $deletePermission = Rbac::PERMISSION_CATEGORY_DELETE;
            $exportPermission = Rbac::PERMISSION_CATEGORY_EXPORT;
        } elseif ($this->element instanceof Tag) {
            $type = Module::t('widgets', 'Tags');
            $controller = 'tag';
            $icon = 'outline/tag';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_TAG_UPDATE;
            $deletePermission = Rbac::PERMISSION_TAG_DELETE;
            $exportPermission = Rbac::PERMISSION_TAG_EXPORT;
        } elseif ($this->element instanceof Slug) {
            $type = Module::t('widgets', 'Slugs');
            $controller = 'slug';
            $icon = 'outline/link';
            $name = $this->element->path;
            $updatePermission = Rbac::PERMISSION_SLUG_UPDATE;
            $deletePermission = Rbac::PERMISSION_SLUG_DELETE;
            $exportPermission = null;
        }
        return $this->render('element-card', [
            'name' => $name,
            'type' => $type,
            'controller' => $controller,
            'icon' => $icon,
            'updatePermission' => $updatePermission,
            'deletePermission' => $deletePermission,
            'exportPermission' => $exportPermission,
            'element' => $this->element,
            'tree' => $this->tree,
        ]);
    }
}
