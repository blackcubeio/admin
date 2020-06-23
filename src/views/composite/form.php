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
 * @package blackcube\admin\views\composite
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $composite \blackcube\core\models\Composite
 * @var $slugForm \blackcube\admin\models\SlugForm
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $nodeComposite \blackcube\core\models\NodeComposite
 * @var $tagBlocs \blackcube\core\models\TagBloc[]
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\SlugForm;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginAdminHookInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
            $composite->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_HEAD : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_HEAD,
                $composite
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('composite', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('composite', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
            </li>
        </ul>
            <?php echo SlugForm::widget([
                'element' => $composite,
                'slugForm' => $slugForm,
            ]); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('composite', 'Composite'); ?></span>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($composite, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($composite, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($composite, 'dateStart', ['class' => 'label']); ?>
                    <?php echo Html::activeDateInput($composite, 'activeDateStart', ['class' => 'textfield'.($composite->hasErrors('dateStart')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($composite, 'dateEnd', ['class' => 'label']); ?>
                    <?php echo Html::activeDateInput($composite, 'activeDateEnd', ['class' => 'textfield'.($composite->hasErrors('dateEnd')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($composite, 'typeId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($composite, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => Module::t('composite', 'No type'),
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-2/12">
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
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-8/12">
                    <?php echo Html::activeLabel($composite, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($composite, 'name', ['class' => 'textfield'.($composite->hasErrors('name')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-4/12">
                    <?php echo Html::activeLabel($nodeComposite, 'nodeId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($nodeComposite, 'nodeId', ArrayHelper::map($nodesQuery->select(['id', 'name', 'level'])->asArray()->all(), 'id', function($item) {
                            $level = (int)$item['level'];
                            $finalName = $item['name'];
                            for ($i = 1; $i < $level; $i++) {
                                $finalName = '  '.$finalName;
                            }
                            return $finalName;
                        }), [
                            'prompt' => Module::t('composite', 'Orphan'),
                            'encodeSpaces' => true
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo Html::beginTag('div', ['blackcube-toggle-element' => Html::bindAureliaAttributes([
                'elementType' => \blackcube\core\models\Composite::getElementType(),
                'elementId' => $composite->id,
                'elementSubData' => 'tags'
            ])]); ?>

                <div class="bloc">
                    <div class="bloc-title flex justify-between" data-toggle-element="source">
                        <span class="title"><?php echo Module::t('composite', 'Tags'); ?></span>
                        <i class="fa fa-chevron-down text-white mt-2"></i>
                    </div>
                </div>
                <div  data-toggle-element="target">
                    <div class="bloc">
                        <div class="w-full bloc-fieldset">
                            <?php echo Html::dropDownList('selectedTags', ArrayHelper::getColumn($composite->tags, 'id'), ArrayHelper::map($selectTagsData, 'tagId', 'tagName', 'categoryName'), ['multiple' => 'multiple', 'blackcube-choices' => '']); ?>
                        </div>
                    </div>
                </div>
            <?php echo Html::endTag('div'); ?>

            <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
                <?php $widgets = $pluginsHandler->runWidgetHook(
                    $composite->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_BEFORE_BLOCS : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_BEFORE_BLOCS,
                        $composite
                ); ?>
                <?php foreach ($widgets as $widget): ?>
                    <?php echo $widget; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($composite->id !== null && $composite->type !== null): ?>
                <?php echo Html::beginTag('div', ['blackcube-toggle-element' => Html::bindAureliaAttributes([
                    'elementType' => \blackcube\core\models\Composite::getElementType(),
                    'elementId' => $composite->id,
                    'elementSubData' => 'blocs'
                ])]); ?>
                    <?php echo Html::beginTag('div', [
                        'blackcube-blocs' => Url::to(['blocs', 'id' => $composite->id])
                    ]); ?>
                        <div class="bloc">
                            <div class="bloc-title flex justify-between" data-toggle-element="source">
                                <span class="title"><?php echo Module::t('composite', 'Content'); ?></span>
                                <i class="fa fa-chevron-down text-white mt-2"></i>
                            </div>
                        </div>
                        <div data-toggle-element="target">
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
                        </div>
                    <?php echo Html::endTag('div'); ?>
                <?php echo Html::endTag('div'); ?>

            <?php endif; ?>

            <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
                <?php $widgets = $pluginsHandler->runWidgetHook(
                $composite->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_TAIL : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_TAIL,
                    $composite
                ); ?>
                <?php foreach ($widgets as $widget): ?>
                    <?php echo $widget; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('composite', 'Cancel'), ['index'], [
                    'class' => 'button-cancel'
                ]); ?>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('composite', 'Save'), [
                    'type' => 'submit',
                    'class' => 'button-submit'
                ]); ?>
            </div>
        <?php echo Html::endForm(); ?>
    </main>
