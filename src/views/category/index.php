<?php
/**
 * index.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $categoriesProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use blackcube\admin\helpers\Heroicons;
use yii\widgets\LinkPager;

$formatter = Yii::$app->formatter;
?>
    <main class="application-content">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_LIST_HEAD); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php echo Html::beginForm(['index'], 'get', ['class' => 'action-form']); ?>
            <div class="action-form-wrapper">
                <div class="action-form-search-wrapper">
                        <?php echo Html::textInput('search', Yii::$app->request->getQueryParam('search'), [
                            'class' => 'action-form-search-input',
                            'placeholder' => Module::t('common', 'Search'),
                        ]); ?>
                        <button type="submit" class="action-form-search-button">
                            <?php echo Heroicons::svg('solid/search', ['class' => 'action-form-search-button-icon']); ?>
                        </button>
                    </div>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_CREATE)): ?>
                    <div class="action-form-buttons">
                        <?php echo Html::beginTag('a', ['href' => Url::to(['create']), 'class' => 'action-form-button']); ?>
                            <?php echo Heroicons::svg('outline/plus', ['class' => 'action-form-button-icon']); ?>
                            <?php echo Module::t('common', 'Create'); ?>
                        <?php echo Html::endTag('a'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php echo Html::endForm(); ?>

        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_LIST_BEFORE_LIST); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php echo Html::beginForm(['index']); ?>
        <div class="elements" data-ajaxify-target="categories-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/color-swatch',
                'title' => Module::t('category', 'Categories'),
                'elementsProvider' => $categoriesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'categories-search'
                ]
            ]); ?>
        </div>
        <?php echo Html::endForm(); ?>
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_CATEGORY_LIST_AFTER_LIST); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_CREATE)): ?>
            <div class="action-form">
                <div class="action-form-wrapper">
                    <div class="action-form-buttons">
                        <?php echo Html::beginTag('a', ['href' => Url::to(['create']), 'class' => 'action-form-button']); ?>
                            <?php echo Heroicons::svg('outline/plus', ['class' => 'action-form-button-icon']); ?>
                            <?php echo Module::t('common', 'Create'); ?>
                        <?php echo Html::endTag('a'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </main>

