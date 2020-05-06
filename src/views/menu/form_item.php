<?php
/**
 * form_item.php
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
 * @var $parentsQuery \yii\db\ActiveQuery
 * @var $routes array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$formatter = Yii::$app->formatter;
?>
<main>
    <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
    <ul class="header">
        <li>
            <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('menu', 'Back'), ['edit', 'id' => $menuItem->menu->id], ['class' => 'button']); ?>
        </li>
        <li>
            <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('menu', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
        </li>
    </ul>

    <div class="bloc">
        <div class="bloc-title">
            <span class="title"><?php echo Module::t('menu', 'Menu item'); ?></span>
        </div>
    </div>
    <div class="bloc">
        <div class="w-full bloc-fieldset md:w-8/12">
            <?php echo Html::activeLabel($menuItem, 'name', ['class' => 'label']); ?>
            <?php echo Html::activeTextInput($menuItem, 'name', ['class' => 'textfield'.($menuItem->hasErrors('name')?' error':'')]); ?>
        </div>
        <div class="w-full bloc-fieldset md:w-4/12">
            <?php echo Html::activeLabel($menuItem, 'route', ['class' => 'label']); ?>
            <div class="dropdown">
                <?php echo Html::activeDropDownList($menuItem, 'route', ArrayHelper::map($routes, 'id', 'name', 'type'), [
                        'prompt' => Module::t('menu', 'Select a route'),
                        'class' => ($menuItem->hasErrors('route')?' error':''),
                ]); ?>
                <div class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="bloc">
        <div class="w-full bloc-fieldset md:w-3/12">
            <?php echo Html::activeLabel($menuItem, 'parentId', ['class' => 'label']); ?>
            <div class="dropdown">
                <?php echo Html::activeDropDownList($menuItem, 'parentId', ArrayHelper::map($parentsQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                    'prompt' => Module::t('menu', 'Root'),
                ]); ?>
                <div class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>
        </div>
    </div>
    <div class="buttons">
        <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('menu', 'Cancel'), ['edit', 'id' => $menuItem->menu->id], [
            'class' => 'button-cancel'
        ]); ?>
        <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('menu', 'Save'), [
            'type' => 'submit',
            'class' => 'button-submit'
        ]); ?>
    </div>
    <?php echo Html::endForm(); ?>
</main>




