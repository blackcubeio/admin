<?php
/**
 * form.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\category
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $category \blackcube\core\models\Category
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;
?>
<main class="application-content">
    <?php echo Html::beginForm('', 'post', [
        'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">
        <?php echo Html::beginTag('a', [
            'class' => 'text-white',
            'href' => Url::to(['index'])
        ]); ?>
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-5 w-5 mr-2']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('category', 'Category'); ?></h3>
        <?php if($category->isNewRecord === false): ?>
        <?php echo Aurelia::component('blackcube-element-toolbar', '', [
            'slugTitle.bind' => Module::t('category', 'Slug'),
            'slugUrl.bind' => Url::to(['slug', 'id' => $category->id]),
            'slugActive.bind' => (($category->slug !== null) && $category->slug->active),
            'sitemapTitle.bind' => Module::t('category', 'Sitemap'),
            'sitemapUrl.bind' => Url::to(['sitemap', 'id' => $category->id]),
            'sitemapActive.bind' => (($category->slug !== null) && ($category->slug->sitemap !== null) && $category->slug->sitemap->active),
            'seoTitle.bind' => Module::t('category', 'SEO'),
            'seoUrl.bind' => Url::to(['seo', 'id' => $category->id]),
            'seoActive.bind' => (($category->slug !== null) && ($category->slug->seo !== null) && $category->slug->seo->active),
            'showTags.bind' => false,
            'slugExists.bind' => ($category->slug !== null)
        ]); ?>
        <?php endif; ?>
        <!-- p class="element-form-header-abstract"><?php echo Module::t('category', 'This is the minimal information needed to create a new category'); ?></p -->
    </div>
    <div class="px-6 pb-6">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $category->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_HEAD : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_HEAD,
                $category
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($category, 'active', ['hint' => Module::t('category', 'Category status')]); ?>
            </div>
            <?php if($category->isNewRecord === true): ?>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activeDropDownList($category, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'prompt' => Module::t('category', 'No type'),
                        'label' => Module::t('category', 'Type'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activeDropDownList($category, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'label' => Module::t('category', 'Language'),
                    ]); ?>
                </div>
            </div>
            <?php else: ?>
                <div class="element-form-bloc-grid-12"  blackcube-view-edit="">
                    <div class="element-form-bloc-cols-6 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDropDownList($category, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => Module::t('category', 'No type'),
                            'label' => Module::t('category', 'Type'),
                        ]); ?>
                    </div>
                    <div class="element-form-bloc-cols-6" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo Module::t('category', 'Type'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo $category->type?->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-6 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDropDownList($category, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'label' => Module::t('category', 'Language'),
                        ]); ?>
                    </div>
                    <div class="element-form-bloc-cols-5" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo Module::t('category', 'Language'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo $category->language?->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-1" data-view-edit="toggle">
                        <button type="button" class="relative inline-flex items-center p-2.5 rounded-md bg-white text-sm font-medium text-gray-500 hover:text-white hover:bg-indigo-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php echo Heroicons::svg('solid/pencil-square', ['class' => 'h-5 w-4']); ?>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeTextInput($category, 'name', []); ?>
            </div>
        </div>
    </div>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $category->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_BEFORE_BLOCS : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_BEFORE_BLOCS,
                $category
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($category->isNewRecord === false) && $category->type !== null): ?>
            <?php echo Html::beginTag('div', ['blackcube-fold' => Aurelia::bindOptions(['element-type' => $category::getElementType(), 'element-id' => $category->id, 'element-sub-data' => 'blocs'])]); ?>
            <div class="element-form-header flex justify-between text-white" data-fold="">
                <h3 class="element-form-header-title">
                    <?php echo Module::t('category', 'Contents'); ?>
                    <span class="inline-flex items-center ml-2 px-1 py-0.5 rounded-full text-xs font-medium bg-white text-indigo-800"> <?php echo $category->getBlocs()->count(); ?> </span>
                </h3>
                <button type="button" data-fold="down">
                    <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-5 w-5']); ?>
                </button>
                <button type="button" data-fold="up" class="hidden">
                    <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-5 w-5']); ?>
                </button>
            </div>
            <?php echo Aurelia::component('blackcube-blocs', '', [
                'data-target-fold' => '',
                'class' => 'hidden',
                'url.bind' => Url::to(['blocs', 'id' => $category->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                    'element' => $category,
                    'blocs' => $blocs
                ])
            ]);?>
            <?php echo Html::endTag('div'); ?>
        <?php endif; ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $category->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_TAIL : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_TAIL,
                $category
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <div class="px-6 pb-6">

        <div class="element-form-buttons">
            <?php echo Html::beginTag('a', [
                'class' => 'element-form-buttons-button',
                'href' => Url::to(['index'])
            ]); ?>
            <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Cancel'); ?>
            <?php echo Html::endTag('a'); ?>
            <?php echo Html::beginTag('button', [
                'class' => 'element-form-buttons-button action',
                'type' => 'submit'
            ]); ?>
            <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Save'); ?>
            <?php echo Html::endTag('button'); ?>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</main>
