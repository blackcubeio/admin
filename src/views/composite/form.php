<?php
/**
 * @var $composite \blackcube\core\models\Composite
 * @var $slugForm \blackcube\admin\models\SlugForm
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $tagBlocs \blackcube\core\models\TagBloc[]
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 */
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
            <?php echo \blackcube\admin\widgets\SlugForm::widget([
                'element' => $composite,
                'slugForm' => $slugForm,
            ]); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title">Composite</span>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($composite, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($composite, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-6/12">
                    <?php echo Html::activeLabel($composite, 'languageId', ['class' => 'label']); ?>
                    <?php /*/ echo Html::activeDropDownList($tag, 'categoryId', ArrayHelper::map($categoriesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'blackcube-choices' => ''
                    ]); /**/?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($composite, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-5/12">
                    <?php echo Html::activeLabel($composite, 'typeId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($composite, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => 'No Type',
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset">
                    <?php echo Html::activeLabel($composite, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($composite, 'name', ['class' => 'textfield'.($composite->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>

            <?php if ($composite->id !== null && $composite->type !== null): ?>
            <?php echo Html::beginTag('div', [
                'blackcube-blocs' => Url::to(['blocs', 'id' => $composite->id])
            ]); ?>
                <div class="bloc">
                    <div class="bloc-title">
                        <span class="title">Contenu</span>
                    </div>
                </div>
                <div data-ajax-target="">
                    <?php echo $this->render('@blackcube/admin/views/common/_blocs', ['blocs' => $blocs, 'element' => $composite]); ?>
                </div>
                <?php if ($composite->type && $composite->type->getBlocTypes()->count() > 0): ?>
                <div class="bloc bloc-tools">
                    <div class="dropdown-tool">
                        <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($composite->type->blocTypes, 'id', 'name'), []); ?>
                        <div class="dropdown-tool-arrow">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <button type="button" name="blocAdd" class="button">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                            <path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm0 2v14h14V5H5zm8 6h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/>
                        </svg>
                    </button>
                </div>
                <?php endif; ?>
            <?php echo Html::endTag('div'); ?>
            <?php endif; ?>

            <div class="buttons">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Cancel'), ['index'], [
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
