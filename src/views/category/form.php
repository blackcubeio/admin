<?php
/**
 * form.php
 *
 * PHP version 7.4+
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
use blackcube\admin\interfaces\PluginAdminHookInterface;
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
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-7 w-7']); ?>
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
                $category->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_HEAD : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_HEAD,
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
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeTextInput($category, 'name', []); ?>
            </div>
        </div>
    </div>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $category->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_BEFORE_BLOCS : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_BEFORE_BLOCS,
                $category
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($category->isNewRecord === false) && $category->type !== null): ?>
            <div class="element-form-header">
                <h3 class="element-form-header-title">
                    <?php echo Module::t('category', 'Content'); ?>
                </h3>
                <!-- p class="element-form-header-abstract"><?php echo Module::t('category', 'This is the minimal information needed to create a new category'); ?></p -->
            </div>
            <?php echo Aurelia::component('blackcube-blocs', '', [
                'url.bind' => Url::to(['blocs', 'id' => $category->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                    'element' => $category,
                    'blocs' => $blocs
                ])
            ]);?>
        <?php endif; ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $category->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_CREATE_TAIL : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_UPDATE_TAIL,
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
