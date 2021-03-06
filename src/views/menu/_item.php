<?php
/**
 * _item.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\menu
 *
 * @var $menuItem \blackcube\core\models\MenuItem
 * @var $level integer
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\core\components\Element;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use blackcube\core\models\Category;
use blackcube\core\models\MenuItem;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$route = $menuItem->route;
try {
    $element = Element::instanciate($menuItem->route, false);
    $elementClass = get_class($element);
} catch(Exception $e) {

}
?>
<tr>
    <td>
        <?php echo Html::beginTag('span', ['class' => 'pl-'.($level * 2)]); ?>
        <?php echo $menuItem->name; ?>
        <?php echo Html::endTag('span'); ?>
    </td>
    <td>
        <?php if (isset($element, $elementClass)):?>
            <?php switch ($elementClass::getElementType()) {
                case 'tag':
                    $type = Module::t('menu', 'Tag');
                    break;
                case 'category':
                    $type = Module::t('menu', 'Category');
                    break;
                case 'node':
                    $type = Module::t('menu', 'Node');
                    break;
                case 'composite':
                    $type = Module::t('menu', 'Composite');
                    break;
                default:
                    $type = Module::t('menu', 'Unknown');
                    break;
            }?>
            <?php echo $type; ?>
        <?php else: ?>
            <?php echo Module::t('menu', 'Regular'); ?>
        <?php endif; ?>
    </td>
    <td>
        <?php if (isset($element)): ?>
            <span><?php echo $element->name; ?></span>
            <span class="text-xs text-gray-600 italic">#<?php echo $element->id; ?></span>
        <?php else: ?>
            <span><?php echo $menuItem->route; ?></span>
        <?php endif; ?>
    </td>
    <td>
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_DELETE)): ?>
            <?php echo Html::beginForm(['delete-item', 'id' => $menuItem->id], 'post', ['data-ajax-modal' => Url::to(['item-modal', 'id' => $menuItem->id])]); ?>
            <button class="button danger">
                <i class="fa fa-trash-alt"></i>
            </button>
        <?php endif; ?>
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_UPDATE)): ?>
            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit-item', 'id' => $menuItem->id], ['class' => 'button']); ?>
            <?php if ($menuItem->order > 1): ?>
                <?php echo Html::a('<i class="fa fa-angle-up"></i>', ['up-item', 'id' => $menuItem->id], ['class' => 'button up', 'data-ajaxify-source' => 'menu-item-list']); ?>
            <?php else: ?>
                <span class="button up inactive"><i class="fa fa-angle-up"></i></span>
            <?php endif; ?>
            <?php $itemCount =  MenuItem::find()->andWhere(['menuId' => $menuItem->menuId, 'parentId' => $menuItem->parentId])->count(); ?>
            <?php if ($menuItem->order < $itemCount): ?>
            <?php echo Html::a('<i class="fa fa-angle-down"></i>', ['down-item', 'id' => $menuItem->id], ['class' => 'button down', 'data-ajaxify-source' => 'menu-item-list']); ?>
            <?php else: ?>
                <span class="button down inactive"><i class="fa fa-angle-down"></i></span>
            <?php endif; ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_DELETE)): ?>
            <?php echo Html::endForm(); ?>
        <?php endif; ?>

    </td>
</tr>
<?php foreach($menuItem->getChildren()->each() as $idx => $subMenuItem): ?>
    <?php /* @var $menuItem \blackcube\core\models\MenuItem */?>
    <?php echo $this->render('_item', ['level' => ($level + 1), 'menuItem' => $subMenuItem]); ?>
<?php endforeach; ?>


