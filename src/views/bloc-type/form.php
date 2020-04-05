<?php
/**
 * @var $blocType \blackcube\core\models\BlocType
 * @var $typeBlocTypes \blackcube\core\models\TypeBlocType[]
 */
use blackcube\admin\helpers\Html;
?>
<div class="flex flex-1">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main>
        <ul class="header">
            <li class="">
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> Back', ['index'], ['class' => 'button']); ?>
            </li>
        </ul>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title">Type de bloc</span>
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
                <span class="title">Types associés</span>
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
            <?php echo Html::a(Yii::t('blackcube.admin', 'Cancel'), ['bloc-type/index'], [
                'class' => 'button-cancel'
            ]); ?>
            <?php echo Html::button(Yii::t('blackcube.admin', 'Save'), [
                'type' => 'submit',
                'class' => 'button-submit'
            ]); ?>
        </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
