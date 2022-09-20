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
 * @package blackcube\admin\views\composite
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $composite \blackcube\core\models\Composite
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $nodeComposite \blackcube\core\models\NodeComposite
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
use blackcube\core\models\Tag;
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
        <h3 class="page-header-title"><?php echo Module::t('composite', 'Composite'); ?></h3>
        <?php if($composite->isNewRecord === false): ?>
        <?php echo Aurelia::component('blackcube-element-toolbar', '', [
            'slugTitle.bind' => Module::t('composite', 'Slug'),
            'slugUrl.bind' => Url::to(['slug', 'id' => $composite->id]),
            'slugActive.bind' => (($composite->slug !== null) && $composite->slug->active),
            'sitemapTitle.bind' => Module::t('composite', 'Sitemap'),
            'sitemapUrl.bind' => Url::to(['sitemap', 'id' => $composite->id]),
            'sitemapActive.bind' => (($composite->slug !== null) && ($composite->slug->sitemap !== null) && $composite->slug->sitemap->active),
            'seoTitle.bind' => Module::t('composite', 'SEO'),
            'seoUrl.bind' => Url::to(['seo', 'id' => $composite->id]),
            'seoActive.bind' => (($composite->slug !== null) && ($composite->slug->seo !== null) && $composite->slug->seo->active),
            'tagsTitle.bind' => Module::t('composite', 'Tags'),
            'tagsUrl.bind' => Url::to(['tag', 'id' => $composite->id]),
            'showTags.bind' => (Tag::find()->count() > 0),
            'slugExists.bind' => ($composite->slug !== null)
        ]); ?>
        <?php endif; ?>
        <!-- p class="element-form-header-abstract"><?php echo Module::t('composite', 'This is the minimal information needed to create a new composite'); ?></p -->
    </div>
    <div class="px-6 pb-6">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $composite->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_HEAD : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_HEAD,
                $composite
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($composite, 'active', ['hint' => Module::t('composite', 'Composite status')]); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDateInput($composite, 'activeDateStart', ['realAttribute' => 'dateStart']); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDateInput($composite, 'activeDateEnd', ['realAttribute' => 'dateEnd']); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($composite, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'prompt' => Module::t('composite', 'No type'),
                        'label' => Module::t('composite', 'Type'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($composite, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'label' => Module::t('composite', 'Language'),
                    ]); ?>
                </div>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-7">
                    <?php echo BlackcubeHtml::activeTextInput($composite, 'name', []); ?>
                </div>
                <div class="element-form-bloc-cols-5">
                    <?php echo BlackcubeHtml::activeDropDownList($nodeComposite, 'nodeId', ArrayHelper::map($nodesQuery->select(['id', 'name', 'level'])->asArray()->all(), 'id', function($item) {
                        $level = (int)$item['level'];
                        $finalName = $item['name'];
                        for ($i = 1; $i < $level; $i++) {
                            $finalName = '  '.$finalName;
                        }
                        return $finalName;
                    }), [
                        'prompt' => Module::t('composite', 'Orphan'),
                        'label' => Module::t('composite', 'Node'),
                        'encodeSpaces' => true,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $composite->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_BEFORE_BLOCS : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_BEFORE_BLOCS,
                $composite
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (($composite->isNewRecord === false) && $composite->type !== null): ?>

        <?php echo Html::beginTag('div', ['blackcube-fold' => Aurelia::bindOptions(['element-type' => $composite::getElementType(), 'element-id' => $composite->id, 'element-sub-data' => 'blocs'])]); ?>
            <div class="element-form-header flex justify-between text-white" data-fold="">
                <h3 class="element-form-header-title">
                    <?php echo Module::t('composite', 'Contents'); ?>
                    <span class="inline-flex items-center ml-2 px-1 py-0.5 rounded-full text-xs font-medium bg-white text-indigo-800"> <?php echo $composite->getBlocs()->count(); ?> </span>
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
                'url.bind' => Url::to(['blocs', 'id' => $composite->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                    'element' => $composite,
                    'blocs' => $blocs
                ])
            ]);?>
        <?php echo Html::endTag('div'); ?>
        <?php endif; ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $composite->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_TAIL : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_TAIL,
                $composite
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
