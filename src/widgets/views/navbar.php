<?php
/**
 * navbar.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets\views
 *
 * @var string $controllerUid
 * @var string $adminUid
 * @var array $widgets
 * @var array $modulesWidgets
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Aurelia;
use Yii;
?>
<nav class="navbar" aria-label="Sidebar">
    <?php  if (Yii::$app->user->can(Rbac::PERMISSION_SITE_DASHBOARD)): ?>
    <div class="navbar-item">
        <?php echo Html::beginTag('a', [
            'href' => Url::to(['/'.$adminUid.'/dashboard/index']),
            'class' => 'navbar-item-link'.($controllerUid === $adminUid.'/dashboard' ? ' active':''),
        ]); ?>
            <?php echo Heroicons::svg('outline/home', ['class' => 'navbar-item-img']); ?>
            <?php echo Module::t('widgets', 'Dashboard'); ?>
        <?php echo Html::endTag('a'); ?>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_USER_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_TYPE_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_MENU_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_LANGUAGE_VIEW)): ?>

    <div class="navbar-item" data-blackcube-section="parameters">
        <button type="button" class="navbar-item-btn" aria-expanded="false">
            <?php echo Heroicons::svg('outline/cog', ['class' => 'navbar-item-img']); ?>
            <?php echo Module::t('widgets', 'Parameters'); ?>
            <?php echo Heroicons::svg('solid/chevron-right', ['class' => 'navbar-item-expander']); ?>
        </button>
        <!-- Expandable link section, show/hide based on state. -->
        <div class="navbar-subitems">
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_USER_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/user/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/user' ? ' active':''),
                ]); ?>
                    <?php echo Heroicons::svg('outline/users', ['class' => 'navbar-item-img']); ?>
                    <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Users'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_LANGUAGE_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/language/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/language' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/flag', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Languages'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/parameter/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/parameter' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/puzzle', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Parameters'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/type/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/type' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/template', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Types'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/bloc-type/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/bloc-type' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/cube', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Bloc types'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_MENU_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/menu/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/menu' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/view-list', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Menus'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)
    || Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)): ?>
    <div class="navbar-item" data-blackcube-section="management">
        <button type="button" class="navbar-item-btn" aria-expanded="false">
            <?php echo Heroicons::svg('outline/book-open', ['class' => 'navbar-item-img']); ?>
            <?php echo Module::t('widgets', 'Management'); ?>
            <?php echo Heroicons::svg('solid/chevron-right', ['class' => 'navbar-item-expander']); ?>
        </button>

        <div class="navbar-subitems">
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/node/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/node' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/folder', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Nodes'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/composite/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/composite' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/document-text', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Composites'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/category/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/category' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/color-swatch', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Categories'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/tag/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/tag' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/tag', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Tags'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/slug/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/slug' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/link', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Slugs'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_VIEW)): ?>
    <div class="navbar-item" data-blackcube-section="plugin">
        <button type="button" class="navbar-item-btn" aria-expanded="false">
            <?php echo Heroicons::svg('outline/beaker', ['class' => 'navbar-item-img']); ?>
            <?php echo Module::t('widgets', 'Plugins'); ?>
            <?php echo Heroicons::svg('solid/chevron-right', ['class' => 'navbar-item-expander']); ?>
        </button>
        <div class="navbar-subitems">
            <?php  if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_VIEW)): ?>
                <?php echo Html::beginTag('a', [
                    'href' => Url::to(['/'.$adminUid.'/plugin/index']),
                    'class' => 'navbar-subitems-link'.($controllerUid === $adminUid.'/plugin' ? ' active':''),
                ]); ?>
                <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'navbar-item-img']); ?>
                <span class="navbar-subitems-title">
                        <?php echo Module::t('widgets', 'Configuration'); ?>
                    </span>
                <!-- span class="navbar-subitems-badge exclamation">
                    20+
                </span -->
                <?php echo Html::endTag('a'); ?>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</nav>