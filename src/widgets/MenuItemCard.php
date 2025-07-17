<?php
/**
 * MenuItemCard.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\widgets;

use blackcube\admin\Module;
use blackcube\core\components\Element;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\MenuItem;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\base\Widget;
use Yii;

/**
 * Widget MenuItemCard
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MenuItemCard extends Widget
{
    /**
     * @var MenuItem
     */
    public $menuItem;

    /**
     * @var int
     */
    public $level;


    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $formatter = Yii::$app->formatter;
        $route = $this->menuItem->route;
        $element = Element::instanciate($route, false);
        if ($element instanceof Node) {
            $type = Module::t('widgets', 'Nodes');
            $icon = 'outline/folder';
            $name = $element->name;
        } elseif ($element instanceof Composite) {
            $type = Module::t('widgets', 'Composites');
            $icon = 'outline/document-text';
            $name = $element->name;
        } elseif ($element instanceof Category) {
            $type = Module::t('widgets', 'Categories');
            $icon = 'outline/color-swatch';
            $name = $element->name;
        } elseif ($element instanceof Tag) {
            $type = Module::t('widgets', 'Tags');
            $icon = 'outline/tag';
            $name = $element->name;
        } elseif ($element instanceof Slug) {
            $type = Module::t('widgets', 'Slugs');
            $icon = 'outline/link';
            $name = $element->path;
        } elseif ($element === null) {
            $type = Module::t('widgets', 'No route');
            $icon = 'outline/no-symbol';
            $name = $route;
        } else {
            $type = Module::t('widgets', 'Route');
            $icon = 'outline/command-line';
            $name = $route;
        }
        return $this->render('menu-item-card', [
            'menuItem' => $this->menuItem,
            'type' => $type,
            'icon' => $icon,
            'name' => $name,
            'level' => $this->level,
        ]);
    }
}
