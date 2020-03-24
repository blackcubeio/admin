<?php
/**
 * @var $tag \blackcube\core\models\Tag
 * @var $slugForm \blackcube\admin\models\SlugForm
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="flex flex-1">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="bg-white flex-1 p-3 overflow-hidden">
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <?php echo \blackcube\admin\widgets\SlugForm::widget([
                'element' => $tag,
                'slugForm' => $slugForm,
            ]); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title">Tag</span>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($tag, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($tag, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-6/12">
                    <?php echo Html::activeLabel($tag, 'categoryId', ['class' => 'label']); ?>
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
                    <?php echo Html::activeLabel($tag, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($tag, 'name', ['class' => 'textfield'.($tag->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>

            <?php echo Html::beginTag('div', [
                'manage-blocs' => Url::to(['tag/blocs', 'id' => $tag->id])
            ]); ?>
                <div class="bloc">
                    <div class="bloc-title">
                        <span class="title">Contenu</span>
                    </div>
                </div>
                <div class="bloc">
                    <?php echo Url::to(['tag/blocs', 'id' => $tag->id]); ?>
                    <!-- AJAX TARGET TO SET THE BLOCS -->
                </div>

                <div class="bloc mb-4 justify-end">
                    <div class="relative border border-gray-200 rounded-l bg-gray-200">
                        <select name="testselect" class="block font-light appearance-none w-full bg-gray-200 text-gray-700 py-1 pl-4 pr-8 focus:outline-none leading-tight">
                            <option>Type 1</option>
                            <option>Type 2</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                    <button type="button" name="testbutton" class="p-1 font-light hover:text-white hover:bg-blue-800 tracking-wider rounded-r mr-3 text-gray-700 bg-gray-200 focus:outline-none">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                            <path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm0 2v14h14V5H5zm8 6h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/>
                        </svg>
                    </button>
                </div>
            <?php echo Html::endTag('div'); ?>

            <div class="buttons">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Cancel'), ['tag/index'], [
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
