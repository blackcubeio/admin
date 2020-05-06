<?php
/**
 * form.php
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
 * @var $menu \blackcube\core\models\Menu
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $menuItemsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('menu', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('menu', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
            </li>
        </ul>

            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('menu', 'Menu'); ?></span>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($menu, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($menu, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-8/12">
                    <?php echo Html::activeLabel($menu, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($menu, 'name', ['class' => 'textfield'.($menu->hasErrors('name')?' error':'')]); ?>
                </div>

                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($menu, 'languageId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($menu, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="buttons">
            <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('menu', 'Cancel'), ['index'], [
                'class' => 'button-cancel'
            ]); ?>
            <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('menu', 'Save'), [
                'type' => 'submit',
                'class' => 'button-submit'
            ]); ?>
        </div>
        <?php echo Html::endForm(); ?>
        <?php if ($menu->getIsNewrecord() === false): ?>
        <div class="form" blackcube-ajaxify="click" blackcube-attach-modal="" data-ajaxify-target="menu-item-list">
            <?php echo $this->render('_form_list', [
                'menu' => $menu,
                'languagesQuery' => $languagesQuery,
                'menuItemsQuery' => $menuItemsQuery,
            ]); ?>
        </div>
        <?php endif; ?>
    </main>

