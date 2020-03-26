<?php
/**
 * @var $type \blackcube\core\models\Type
 * @var $blocTypesQuery \blackcube\core\models\FilterActiveQuery
 * @var $typeBlocTypes \blackcube\core\models\TypeBlocType[]
 * @var $controllers array
 */
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="flex flex-1" loader-done="">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="bg-white flex-1 p-3 overflow-hidden">
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title">Type</span>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset">
                    <?php echo Html::activeLabel($type, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'name', ['class' => 'textfield'.($type->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-4/12">
                    <?php echo Html::activeLabel($type, 'controller', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($type, 'controller', ArrayHelper::map($controllers, 'id', 'name'), [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-4/12">
                    <?php echo Html::activeLabel($type, 'action', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'action', ['class' => 'textfield'.($type->hasErrors('action')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-2/12">
                    <?php echo Html::activeLabel($type, 'minBlocs', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'minBlocs', ['class' => 'textfield'.($type->hasErrors('minBlocs')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-2/12">
                    <?php echo Html::activeLabel($type, 'maxBlocs', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($type, 'maxBlocs', ['class' => 'textfield'.($type->hasErrors('maxBlocs')?' error':'')]); ?>
                </div>
            </div>

            <div class="bloc">
                <div class="bloc-title">
                    <span class="title">Types de blocs autorisés</span>
                </div>
            </div>

            <div class="bloc">
                <?php foreach ($typeBlocTypes as $i => $typeBlocType): ?>
                    <div class="w-full bloc-fieldset md:w-2/12">
                        <?php echo Html::activeCheckbox($typeBlocType, '['.$i.']allowed', ['label' => false, 'class' => 'checkbox']); ?>
                        <?php echo Html::activeLabel($typeBlocType, '['.$i.']allowed', ['class' => 'label', 'style' => 'display:inline-block;', 'label' => $typeBlocType->blocType->name]); ?>
                        <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']typeId'); ?>
                        <?php echo Html::activeHiddenInput($typeBlocType, '['.$i.']blocTypeId'); ?>
                    </div>
                <?php endforeach; ?>
            </div>


            <div class="buttons">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Cancel'), ['type/index'], [
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
