<?php
/**
 * form_account.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $user \blackcube\admin\models\Administrator
 * @var $passwordSecurity \blackcube\core\validators\PasswordStrengthValidator
 * @var $passkeysQuery \yii\db\ActiveQuery
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
    <div class="element-form-wrapper">
    <?php echo Html::beginForm('', 'post', [
        // 'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">

        <h3 class="page-header-title"><?php echo Module::t('user', 'Account'); ?></h3>
    </div>
    <div class="px-6 pb-6">
        <div class="element-form-bloc">
            <?php /*/ ?>
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($user, 'active', ['hint' => Module::t('user', 'User status')]); ?>
            </div>
            <?php /**/ ?>
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
                <div class="element-form-bloc-cols-12">
                    <span class="text-xs italic">
                    <?php echo $passwordSecurity->showPasswordRules(); ?>
                    </span>
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

    <?php echo Html::endForm(); ?>

    <div class="mt-4">
        <div class="element-form-bloc-wrapper">
            <div class="element-form-bloc">
                <h3 class="element-form-bloc-title">
                    <?php echo Module::t('user', 'Passkeys'); ?>
                </h3>
                <div class="element-form-bloc-inner">
                    <?php if(isset($passkeysQuery)): ?>
                    <div class="element-form-bloc-stacked">
                        <?php foreach($passkeysQuery->each() as $passkey): ?>
                            <?php echo Html::beginForm(['delete-passkey', 'id' => $passkey->id], 'post', [
                            ]); ?>
                        <div class="flex justify-between">
                            <span>
                                <?php echo empty($passkey->name) ? $passkey->id : $passkey->name; ?>
                                <span class="text-xs italic">
                                    (<?php echo Yii::$app->formatter->asDatetime($passkey->dateCreate); ?>)
                                </span>
                            </span>
                            <span>
                                <?php echo Html::beginTag('button', [
                                    'type' => 'submit',
                                    'class' => 'element-form-bloc-toolbar-buttons-button delete'
                                ]); ?>
                                    <span class="sr-only"><?php echo Module::t('common', 'Delete'); ?></span>
                                    <?php echo Heroicons::svg('outline/trash', ['class' => 'h-4 w-4']); ?>
                                <?php echo Html::endTag('button'); ?>
                            </span>
                        </div>
                            <?php echo Html::endForm(); ?>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div class="element-form-bloc-toolbar">
                        <span class="element-form-bloc-toolbar-buttons">
                            <?php echo Html::beginTag('button', [
                                'type' => 'button',
                                'name' => 'attachDevice',
                                'blackcube-attach-device' => '',
                                'class' => 'element-form-bloc-toolbar-buttons-button'
                            ]); ?>
                                <span class="sr-only"><?php echo Module::t('user', 'Create passkey'); ?></span>
                                <?php echo Heroicons::svg('outline/finger-print', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('button'); ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>

