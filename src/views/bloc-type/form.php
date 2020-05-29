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
 * @package blackcube\admin\views\bloc-type
 *
 * @var $blocType \blackcube\core\models\BlocType
 * @var $typeBlocTypes \blackcube\core\models\TypeBlocType[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;

?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
        <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('bloc-type', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('bloc-type', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
            </li>
        </ul>

        <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('bloc-type', 'Bloc type'); ?></span>
                </div>
            </div>
        <div class="bloc">
            <div class="w-full md:w-1/2 bloc-fieldset">
                    <?php echo Html::activeLabel($blocType, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($blocType, 'name', ['class' => 'textfield'.($blocType->hasErrors('name')?' error':'')]); ?>
                </div>
                <div class="w-full md:w-1/2 bloc-fieldset">
                    <?php echo Html::activeLabel($blocType, 'view', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($blocType, 'view', ['class' => 'textfield'.($blocType->hasErrors('view')?' error':'')]); ?>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full px-3">
                    <?php echo Html::activeLabel($blocType, 'template', ['class' => 'block uppercase tracking-wide text-gray-700 text-xs font-light mb-1']); ?>
                    <?php echo Html::activeSchema($blocType, 'template'); ?>
                </div>
            </div>
        <div class="bloc">
            <div class="bloc-title">
                <span class="title"><?php echo Module::t('bloc-type', 'Associated types'); ?></span>
            </div>
        </div>

        <div class="bloc">
        <?php foreach ($typeBlocTypes as $i => $typeBlocType): ?>
                <div class="w-full bloc-fieldset md:w-2/12">
                    <?php echo Html::activeCheckbox($typeBlocType, '['.$i.']allowed', ['label' => false, 'class' => 'checkbox']); ?>
                    <?php echo Html::activeLabel($typeBlocType, '['.$i.']allowed', ['class' => 'label', 'style' => 'display:inline-block;', 'label' => $typeBlocType->type->name]); ?>
                    <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']typeId'); ?>
                    <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']blocTypeId'); ?>
                </div>
        <?php endforeach; ?>
                </div>

        <div class="buttons">
            <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('bloc-type', 'Cancel'), ['index'], [
                'class' => 'button-cancel'
            ]); ?>
            <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('bloc-type', 'Save'), [
                'type' => 'submit',
                'class' => 'button-submit'
            ]); ?>
        </div>
        <?php echo Html::endForm(); ?>
    </main>
