<?php
/**
 * header.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets\views
 *
 * @var $previewManager \blackcube\core\components\PreviewManager
 * @var $searchForm \blackcube\admin\models\SearchForm
 * @var $currentModuleUid string
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\helpers\Tailwind;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Aurelia;
use yii\helpers\Url;
?>
<div class="application-header">
    <?php
        echo Aurelia::component('blackcube-burger', '', []);
    ?>
    <div class="application-header-wrapper">
        <div class="application-header-search">
            <?php echo Html::beginForm([$currentModuleUid.'/search/index'], 'post', ['class' => 'w-full flex md:ml-0']); ?>
                <?php echo Html::activeLabel($searchForm, 'search', [
                    'class' => 'sr-only',
                    'label' => Module::t('common', 'Search'),
                ]); ?>
                <div class="application-header-search-box">
                    <div class="application-header-search-icon-wrapper">
                        <?php echo Heroicons::svg('solid/search', ['class' => 'application-header-search-icon']); ?>
                    </div>
                    <?php /**/ echo Html::activeTextInput($searchForm, 'search', [
                        'class' => 'application-header-search-field',
                        'placeholder' => Module::t('common', 'Search'),
                        'name' => 'search',
                        'type' => 'search',
                    ]); /**/ ?>
                </div>
            <?php echo Html::endForm(); ?>
        </div>
        <div class="application-header-accessory">
            <!-- button class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <span class="sr-only">View notifications</span>
                <?php echo Heroicons::svg('outline/bell', ['class' => 'h-6 w-6']); ?>
            </button -->
            <?php echo Html::beginTag('button', [
                'class' => 'preview',
                'data-ajaxify-source' => 'header-preview',
                'data-ajaxify-target' => 'header-preview',
                'data-ajaxify-url' => Url::to([$currentModuleUid.'/ajax/preview']),
            ]); ?>
                <span class="sr-only"><?php Module::t('widgets', 'Preview'); ?></span>
                <?php echo Heroicons::svg(
                    $previewManager->check() ? 'outline/eye' : 'outline/eye-off',
                        ['class' => 'preview-icon']);
                ?>
            <?php echo Html::endTag('button'); ?>
            <?php
                echo Aurelia::component('blackcube-profile', '', [
                    'initials.bind' => Yii::$app->user->identity->getInitials(),
                    'items.bind' =>  [
                        // ['label' => 'Parametres', 'url' => '#', 'active' => false],
                        ['label' => Module::t('widgets', 'Account'), 'url' => Url::to([$currentModuleUid.'/user/account']), 'active' => ($currentModuleUid.'/user/account' === '/'.Yii::$app->controller->action->getUniqueId())],
                        ['label' => Module::t('widgets', 'Logout'), 'url' => Url::to([$currentModuleUid.'/authentication/logout']), 'active' => false],
                    ],
                    'class' => 'ml-3 relative'
                ]);
            ?>
        </div>
    </div>
</div>