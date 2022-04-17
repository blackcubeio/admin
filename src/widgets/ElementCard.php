<?php
/**
 * ElementCard.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
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
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
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
        } elseif ($this->element instanceof Composite) {
            $type = Module::t('widgets', 'Composites');
            $controller = 'composite';
            $icon = 'outline/document-text';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_COMPOSITE_UPDATE;
            $deletePermission = Rbac::PERMISSION_COMPOSITE_DELETE;
        } elseif ($this->element instanceof Category) {
            $type = Module::t('widgets', 'Categories');
            $controller = 'category';
            $icon = 'outline/color-swatch';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_CATEGORY_UPDATE;
            $deletePermission = Rbac::PERMISSION_CATEGORY_DELETE;
        } elseif ($this->element instanceof Tag) {
            $type = Module::t('widgets', 'Tags');
            $controller = 'tag';
            $icon = 'outline/tag';
            $name = $this->element->name;
            $updatePermission = Rbac::PERMISSION_TAG_UPDATE;
            $deletePermission = Rbac::PERMISSION_TAG_DELETE;
        } elseif ($this->element instanceof Slug) {
            $type = Module::t('widgets', 'Slugs');
            $controller = 'slug';
            $icon = 'outline/link';
            $name = $this->element->path;
            $updatePermission = Rbac::PERMISSION_SLUG_UPDATE;
            $deletePermission = Rbac::PERMISSION_SLUG_DELETE;
        }
        return $this->render('element-card', [
            'name' => $name,
            'type' => $type,
            'controller' => $controller,
            'icon' => $icon,
            'updatePermission' => $updatePermission,
            'deletePermission' => $deletePermission,
            'element' => $this->element,
            'tree' => $this->tree,
        ]);
    }
}
