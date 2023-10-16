<?php
/**
 * category.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\import\category
 *
 * @var $jsonData array
 * @var $typesQuery \yii\db\ActiveQuery
 * @var $languagesQuery \yii\db\ActiveQuery
 * @var $nodesQuery \yii\db\ActiveQuery
 * @var $tagsQuery \yii\db\ActiveQuery
 * @var $frequencies array
 * @var $priorities array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use blackcube\core\models\Parameter;
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
        <h3 class="page-header-title"><?php echo Module::t('import', 'Import'); ?></h3>
        <p class="element-form-header-abstract"><?php echo Module::t('import', 'This is the category which will be imported'); ?></p>
    </div>
    <div class="px-6 pb-6">

        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::checkbox('active', $jsonData['active'] , [
                    'hint' => Module::t('import', 'Category status'),
                    'label' => Module::t('import', 'Category active'),
                    'disabled' => 'disabled'
                ]); ?>
            </div>
            <?php if (isset($jsonData['slug']) === true): ?>
                <?php echo $this->render('_slug', [
                    'slug' => $jsonData['slug']??null,
                    'frequencies' => $frequencies,
                    'priorities' => $priorities,
                ]); ?>
            <?php endif; ?>
            <div class="element-form-bloc-grid-12">

                <div class="element-form-bloc-cols-9">
                    <?php echo BlackcubeHtml::dropDownList('typeId', $jsonData['typeId'], ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'prompt' => Module::t('import', 'No type'),
                        'label' => Module::t('import', 'Type'),
                        'disabled' => 'disabled'
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::dropDownList('languageId', $jsonData['languageId'], ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'label' => Module::t('import', 'Language'),
                        'disabled' => 'disabled'
                    ]); ?>
                </div>
            </div>

            <div class="element-form-bloc-stacked">
                    <?php echo BlackcubeHtml::input('text','name', $jsonData['name'], [
                            'label' => Module::t('import', 'Name'),
                            'disabled' => 'disabled'
                    ]); ?>
            </div>
            <?php echo $this->render('_blocs', [
                'blocs' => $jsonData['blocs']??null,
            ]); ?>

        </div>
        <?php /*/ ?>
        </div>
    </div>

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
                $category->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_CREATE_TAIL : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_COMPOSITE_UPDATE_TAIL,
                $category
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
 <?php /**/ ?>
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
            <?php echo Module::t('import', 'Import'); ?>
            <?php echo Html::endTag('button'); ?>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</main>
