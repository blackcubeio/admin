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
 * @package blackcube\admin\views\tag
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $tag \blackcube\core\models\Tag
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
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
        <h3 class="page-header-title"><?php echo Module::t('tag', 'Tag'); ?></h3>
        <?php if($tag->isNewRecord === false): ?>
        <?php echo Aurelia::component('blackcube-element-toolbar', '', [
            'slugTitle.bind' => Module::t('tag', 'Slug'),
            'slugUrl.bind' => Url::to(['slug', 'id' => $tag->id]),
            'slugActive.bind' => (($tag->slug !== null) && $tag->slug->active),
            'sitemapTitle.bind' => Module::t('tag', 'Sitemap'),
            'sitemapUrl.bind' => Url::to(['sitemap', 'id' => $tag->id]),
            'sitemapActive.bind' => (($tag->slug !== null) && ($tag->slug->sitemap !== null) && $tag->slug->sitemap->active),
            'seoTitle.bind' => Module::t('tag', 'SEO'),
            'seoUrl.bind' => Url::to(['seo', 'id' => $tag->id]),
            'seoActive.bind' => (($tag->slug !== null) && ($tag->slug->seo !== null) && $tag->slug->seo->active),
            'showTags.bind' => false,
            'slugExists.bind' => ($tag->slug !== null)
        ]); ?>
        <?php endif; ?>
        <!-- p class="element-form-header-abstract"><?php echo Module::t('tag', 'This is the minimal information needed to create a new tag'); ?></p -->
    </div>
    <div class="px-6 pb-6">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $tag->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_CREATE_HEAD : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_UPDATE_HEAD,
                $tag
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($tag, 'active', ['hint' => Module::t('tag', 'Tag status')]); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activeDropDownList($tag, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'prompt' => Module::t('tag', 'No type'),
                        'label' => Module::t('tag', 'Type'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activeDropDownList($tag, 'categoryId', ArrayHelper::map($categoriesQuery->select(['id', 'name', 'languageId'])->asArray()->all(), 'id', function($item) { return $item['name'].' ('.$item['languageId'].')'; }), [
                        'label' => Module::t('tag', 'Category'),
                    ]); ?>
                </div>
            </div>
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeTextInput($tag, 'name', []); ?>
            </div>
        </div>
    </div>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $tag->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_CREATE_BEFORE_BLOCS : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_UPDATE_BEFORE_BLOCS,
                $tag
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($tag->isNewRecord === false) && $tag->type !== null): ?>
            <div class="element-form-header">
                <h3 class="element-form-header-title">
                    <?php echo Module::t('tag', 'Content'); ?>
                </h3>
                <!-- p class="element-form-header-abstract"><?php echo Module::t('tag', 'This is the minimal information needed to create a new tag'); ?></p -->
            </div>
            <?php echo Aurelia::component('blackcube-blocs', '', [
                'url.bind' => Url::to(['blocs', 'id' => $tag->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                    'element' => $tag,
                    'blocs' => $blocs
                ])
            ]);?>
        <?php endif; ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $tag->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_CREATE_TAIL : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_TAG_UPDATE_TAIL,
                $tag
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
