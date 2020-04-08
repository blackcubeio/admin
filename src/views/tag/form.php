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
 * @package blackcube\admin\views\tag
 *
 * @var $this yii\web\View
 * @var $tag \blackcube\core\models\Tag
 * @var $slugForm \blackcube\admin\models\SlugForm
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $tagBlocs \blackcube\core\models\TagBloc[]
 * @var $blocs \blackcube\core\models\Bloc[]
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\SlugForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main>
        <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('tag', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::a('<i class="fa fa-check mr-2"></i> '.Module::t('tag', 'Save'), ['index'], ['class' => 'button']); ?>
            </li>
        </ul>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <?php echo SlugForm::widget([
                'element' => $tag,
                'slugForm' => $slugForm,
            ]); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('tag', 'Tag'); ?></span>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($tag, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($tag, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-6/12">
                    <?php echo Html::activeLabel($tag, 'categoryId', ['class' => 'label']); ?>
                    <?php /*/ echo Html::activeDropDownList($tag, 'categoryId', ArrayHelper::map($categoriesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'blackcube-choices' => ''
                    ]); /**/?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($tag, 'categoryId', ArrayHelper::map($categoriesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-5/12">
                    <?php echo Html::activeLabel($tag, 'typeId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($tag, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => Module::t('tag', 'No type'),
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset">
                    <?php echo Html::activeLabel($tag, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($tag, 'name', ['class' => 'textfield'.($tag->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>

            <?php if ($tag->id !== null && $tag->type !== null): ?>
            <?php echo Html::beginTag('div', [
                'blackcube-blocs' => Url::to(['blocs', 'id' => $tag->id])
            ]); ?>
                <div class="bloc">
                    <div class="bloc-title">
                        <span class="title"><?php echo Module::t('tag', 'Content'); ?></span>
                    </div>
                </div>
                <div data-ajax-target="">
                    <?php echo $this->render('@blackcube/admin/views/common/_blocs', ['blocs' => $blocs, 'element' => $tag]); ?>
                </div>
                <?php if ($tag->type && $tag->type->getBlocTypes()->count() > 0): ?>
                <div class="bloc bloc-tools">
                    <div class="dropdown-tool">
                        <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($tag->type->blocTypes, 'id', 'name'), []); ?>
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
                <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('tag', 'Cancel'), ['index'], [
                    'class' => 'button-cancel'
                ]); ?>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('tag', 'Save'), [
                    'type' => 'submit',
                    'class' => 'button-submit'
                ]); ?>
            </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
