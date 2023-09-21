<?php
/**
 * form_item.php
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
 * @var $menuItem \blackcube\core\models\MenuItem
 * @var $parents array
 * @var $routes array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;

$formatter = Yii::$app->formatter;
?>

<main class="application-content">
    <?php echo Html::beginForm('', 'post', [
        'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">
        <?php echo Html::beginTag('a', [
            'class' => 'text-white',
            'href' => Url::to(['edit', 'id' => $menu->id])
        ]); ?>
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-5 w-5 mr-2']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('menu', 'Menu item'); ?></h3>
    </div>

    <div class="px-6 pb-6">
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::activeTextInput($menuItem, 'name', []); ?>
        </div>
        <div class="element-form-bloc-grid-12">
            <div class="element-form-bloc-cols-6">
                <?php echo BlackcubeHtml::activeDropDownList($menuItem, 'route', ArrayHelper::map($routes, 'id', 'name', 'type'), [
                    'prompt' => Module::t('menu', 'Select a route'),
                ]); ?>
            </div>
            <div class="element-form-bloc-cols-6">
                <?php echo BlackcubeHtml::activeDropDownList($menuItem, 'parentId', ArrayHelper::map($parents, 'id', 'name'), [
                    'prompt' => Module::t('menu', 'Root'),
                    'encodeSpaces' => true,
                    'label' => Module::t('menu', 'Parent'),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="px-6 pb-6">

        <div class="element-form-buttons">
            <?php echo Html::beginTag('a', [
                'class' => 'element-form-buttons-button',
                'href' => Url::to(['edit', 'id' => $menu->id])
            ]); ?>
            <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Cancel'); ?>
            <?php echo Html::endTag('a'); ?>
            <?php echo Html::beginTag('button', [
                'class' => 'element-form-buttons-button action',
                'type' => 'submit'
            ]); ?>
            <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Save'); ?>
            <?php echo Html::endTag('button'); ?>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</main>
