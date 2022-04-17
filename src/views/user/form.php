<?php
/**
 * form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\user
 *
 * @var $user \blackcube\admin\models\Administrator
 * @var $userRolesById array
 * @var $userPermissionsById array
 * @var $userAssignmentsById array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;
use yii\helpers\Url;
use blackcube\admin\helpers\Aurelia;

$authManager = Yii::$app->authManager;

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

        <h3 class="page-header-title"><?php echo Module::t('user', 'User'); ?></h3>
    </div>
    <div class="px-6 pb-6">
        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($user, 'active', ['hint' => Module::t('user', 'User status')]); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-4">
                    <?php echo BlackcubeHtml::activeTextInput($user, 'email', []); ?>
                </div>
                <div class="element-form-bloc-cols-4">
                    <?php echo BlackcubeHtml::activeTextInput($user, 'firstname', []); ?>
                </div>
                <div class="element-form-bloc-cols-4">
                    <?php echo BlackcubeHtml::activeTextInput($user, 'lastname', []); ?>
                </div>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activePasswordInput($user, 'newPassword', []); ?>
                </div>
                <div class="element-form-bloc-cols-6">
                    <?php echo BlackcubeHtml::activePasswordInput($user, 'checkPassword', []); ?>
                </div>
            </div>
        </div>
    </div>
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
    <?php if($user->isNewRecord === false): ?>
    <?php echo Aurelia::component('blackcube-permissions', '', [
        'url.bind' => Url::to(['rbac', 'id' => $user->id])
    ]);?>
    <?php endif; ?>

    <?php echo Html::endForm(); ?>
</main>

