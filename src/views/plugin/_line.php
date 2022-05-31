<?php
/**
 * _list.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\plugin
 *
 * @var $pluginManager \blackcube\core\interfaces\PluginManagerInterface
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginManagerConfigurableInterface;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;

$wrapperOptions = [
    'class' => 'card-wrapper'
];

$formatter = Yii::$app->formatter;
$currentCategoryId = null;
?>
<div class="card">
    <?php echo Html::beginTag('div', $wrapperOptions); ?>
    <div class="card-title-block">
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_UPDATE) && $pluginManager->getIsRegistered() && $pluginManager instanceof PluginManagerConfigurableInterface && $pluginManager->getConfigureRoute() !== null): ?>
            <?php echo Html::a($pluginManager->getName(), $pluginManager->getConfigureRoute(), ['class' => 'card-title']); ?>
        <?php else: ?>
            <?php echo Html::tag('span', $pluginManager->getName(), ['class' => 'card-title']); ?>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="card-body-info-wrapper">
            <p class="card-body-info-type">
                <?php echo $pluginManager->getVersion(); ?>
            </p>
        </div>
        <div class="card-body-actions-wrapper">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <span class="card-body-actions">
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_UPDATE)): ?>
                    <?php if ($pluginManager->getIsRegistered()): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to(['toggle-register', 'id' => $pluginManager->getId()]),
                            'data-ajaxify-source' => 'plugin-toggle-'.$pluginManager->getId(),
                            'class' => 'card-body-actions-button active'
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Unregister'); ?></span>
                            <?php echo Heroicons::svg('outline/status-online', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php if ($pluginManager->getIsActive()): ?>
                            <?php echo Html::beginTag('a', [
                                'href' => Url::to(['toggle', 'id' => $pluginManager->getId()]),
                                'data-ajaxify-source' => 'plugin-toggle-'.$pluginManager->getId(),
                                'class' => 'card-body-actions-button active'
                            ]); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Unregister'); ?></span>
                            <?php echo Heroicons::svg('outline/play', ['class' => 'card-body-actions-button-icon']); ?>
                            <?php echo Html::endTag('a'); ?>
                        <?php else: ?>
                            <?php echo Html::beginTag('a', [
                                'href' => Url::to(['toggle', 'id' => $pluginManager->getId()]),
                                'data-ajaxify-source' => 'plugin-toggle-'.$pluginManager->getId(),
                                'class' => 'card-body-actions-button inactive'
                            ]); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Register'); ?></span>
                            <?php echo Heroicons::svg('outline/pause', ['class' => 'card-body-actions-button-icon']); ?>
                            <?php echo Html::endTag('a'); ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php echo Html::beginTag('a', [
                                'href' => Url::to(['toggle-register', 'id' => $pluginManager->getId()]),
                                'data-ajaxify-source' => 'plugin-toggle-'.$pluginManager->getId(),
                                'class' => 'card-body-actions-button inactive'
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Register'); ?></span>
                            <?php echo Heroicons::svg('outline/status-offline', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php echo Html::beginTag('span', [
                            'class' => 'card-body-actions-button disabled'
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Register'); ?></span>
                        <?php echo Heroicons::svg('outline/pause', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('span'); ?>
                    <?php endif; ?>

                    <?php if ($pluginManager->getIsRegistered() && $pluginManager instanceof PluginManagerConfigurableInterface && $pluginManager->getConfigureRoute() !== null): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to($pluginManager->getConfigureRoute()), 'class' => 'card-body-actions-button']); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php else: ?>
                        <?php echo Html::beginTag('span', ['class' => 'card-body-actions-button disabled']); ?>
                            <span class="sr-only"><?php echo Module::t('plugin', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('span'); ?>
                    <?php endif; ?>
                    <?php if ($pluginManager->getIsRegistered()): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['edit', 'id' => $pluginManager->getId()]), 'class' => 'card-body-actions-button']); ?>
                        <span class="sr-only"><?php echo Module::t('plugin', 'Configure'); ?></span>
                        <?php echo Heroicons::svg('outline/adjustments', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php else: ?>
                        <?php echo Html::beginTag('span', ['class' => 'card-body-actions-button disabled']); ?>
                        <span class="sr-only"><?php echo Module::t('plugin', 'Configure'); ?></span>
                        <?php echo Heroicons::svg('outline/adjustments', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('span'); ?>
                    <?php endif; ?>

                <?php endif; ?>
                </span>

        </div>
    </div>
</div>