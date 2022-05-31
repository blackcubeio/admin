<?php
/**
 * index.php
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
 * @var $languagesProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use blackcube\admin\helpers\Heroicons;

$formatter = Yii::$app->formatter;
?>
    <main class="application-content">
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
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_LANGUAGE_CREATE)): ?>
                    <div class="action-form-buttons">
                        <?php echo Html::beginTag('a', ['href' => Url::to(['create']), 'class' => 'action-form-button']); ?>
                            <?php echo Heroicons::svg('outline/plus', ['class' => 'action-form-button-icon']); ?>
                            <?php echo Module::t('common', 'Create'); ?>
                        <?php echo Html::endTag('a'); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php echo Html::endForm(); ?>

        <?php echo Html::beginForm(['index']); ?>
        <div class="elements" data-ajaxify-target="languages-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/flag',
                'title' => Module::t('language', 'Languages'),
                'elementsProvider' => $languagesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'languages-search'
                ]
            ]); ?>
        </div>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_LANGUAGE_CREATE)): ?>
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

