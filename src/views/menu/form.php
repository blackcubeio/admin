<?php
/**
 * form.php
 *
 * PHP version 7.4+
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
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Aurelia;

?>
<main class="application-content">
    <?php echo Html::beginForm('', 'post', [
        'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">
        <?php echo Html::beginTag('a', [
            'class' => 'text-white',
            'href' => Url::to(['index'])
        ]); ?>
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-5 w-5 mr-2']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('menu', 'Menu'); ?></h3>
    </div>

    <div class="px-6 pb-6">
        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($menu, 'active', ['hint' => Module::t('menu', 'Menu status')]); ?>
            </div>
        </div>
        <div class="element-form-bloc-grid-12">
            <div class="element-form-bloc-cols-9">
                <?php echo BlackcubeHtml::activeTextInput($menu, 'name', []); ?>
            </div>
            <div class="element-form-bloc-cols-3">
                <?php echo BlackcubeHtml::activeDropDownList($menu, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                    'label' => Module::t('menu', 'Language'),
                ]); ?>
            </div>
        </div>
    </div>
    <div class="px-6 pb-6">

        <div class="element-form-buttons">
            <?php echo Html::beginTag('a', [
                'class' => 'element-form-buttons-button',
                'href' => Url::to(['index'])
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

        <?php if ($menu->getIsNewrecord() === false): ?>
            <?php echo $this->render('_form_list', [
                'menu' => $menu,
                'languagesQuery' => $languagesQuery,
                'menuItemsQuery' => $menuItemsQuery,
            ]); ?>
        <?php endif; ?>
</main>

