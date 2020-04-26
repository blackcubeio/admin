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
 * @package blackcube\admin\views\type
 *
 * @var $type \blackcube\core\models\Type
 * @var $blocTypesQuery \blackcube\core\models\FilterActiveQuery
 * @var $typeBlocTypes \blackcube\core\models\TypeBlocType[]
 * @var $routes array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <ul class="header">
                <li>
                    <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('type', 'Back'), ['index'], ['class' => 'button']); ?>
                </li>
                <li>
                    <?php echo Html::a('<i class="fa fa-check mr-2"></i> '.Module::t('type', 'Save'), ['index'], ['class' => 'button']); ?>
                </li>
            </ul>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('type', 'Type'); ?></span>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset">
                    <?php echo Html::activeLabel($type, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'name', ['class' => 'textfield'.($type->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-6/12">
                    <?php echo Html::activeLabel($type, 'route', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($type, 'route', $routes, [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($type, 'minBlocs', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'minBlocs', ['class' => 'textfield'.($type->hasErrors('minBlocs')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($type, 'maxBlocs', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'maxBlocs', ['class' => 'textfield'.($type->hasErrors('maxBlocs')?' error':'')]); ?>
                </div>
            </div>

            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('type', 'Allowed bloc types'); ?></span>
                </div>
            </div>

            <div class="bloc">
                <?php foreach ($typeBlocTypes as $i => $typeBlocType): ?>
                    <div class="w-full bloc-fieldset md:w-2/12">
                        <?php echo Html::activeCheckbox($typeBlocType, '['.$i.']allowed', ['label' => false, 'class' => 'checkbox']); ?>
                        <?php echo Html::activeLabel($typeBlocType, '['.$i.']allowed', ['class' => 'label', 'style' => 'display:inline;', 'label' => $typeBlocType->blocType->name]); ?>
                        <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']typeId'); ?>
                        <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']blocTypeId'); ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('type', 'Cancel'), ['index'], [
                    'class' => 'button-cancel'
                ]); ?>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('type', 'Save'), [
                    'type' => 'submit',
                    'class' => 'button-submit'
                ]); ?>
            </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
