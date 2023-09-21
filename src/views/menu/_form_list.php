<?php
/**
 * _form_list.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\menu
 *
 * @var $menu \blackcube\core\models\Menu
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $menuItemsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\widgets\MenuItemCard;
use blackcube\admin\helpers\Heroicons;

?>
<?php echo Html::beginForm('create-item') ;?>
<div class="elements">
    <div class="element-form-header">
        <h3 class="element-form-header-title">
            <?php echo Module::t('menu', 'Items'); ?>
        </h3>
        <!-- p class="element-form-header-abstract">This is the minimal information needed to create a new composite</p -->
    </div>

        <?php echo Html::beginTag('div', [
            'class' => 'elements-list',
            'data-ajaxify-target' => 'refresh-menu-items'
        ]); ?>
            <?php echo $this->render('_form_menu_items', [
                'menuItemsQuery' => $menuItemsQuery
            ]); ?>
    <div class="px-6 pb-6">
            <div class="element-form-buttons">
                <?php echo Html::beginTag('a', [
                    'class' => 'element-form-buttons-button action',
                    'href' => Url::to(['create-item', 'menuId' => $menu->id])
                ]); ?>
                <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
                <?php echo Module::t('menu', 'Add item'); ?>
                <?php echo Html::endTag('a'); ?>
            </div>
    </div>
        <?php echo  Html::endTag('div'); ?>


</div>

<?php echo Html::endForm(); ?>
