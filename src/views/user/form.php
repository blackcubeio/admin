<?php
/**
 * form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
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

$authManager = Yii::$app->authManager;

?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
        <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('user', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('user', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
            </li>
        </ul>

        <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('user', 'User'); ?></span>
                </div>
            </div>
        <div class="bloc">
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($user, 'active', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($user, 'active', []); ?>
            </div>

            <div class="w-full md:w-5/12 bloc-fieldset">
                <?php echo Html::activeLabel($user, 'email', ['class' => 'label']); ?>
                <?php echo Html::activeTextInput($user, 'email', ['class' => 'textfield'.($user->hasErrors('email')?' error':'')]); ?>
            </div>
            <div class="w-full md:w-3/12 bloc-fieldset">
                <?php echo Html::activeLabel($user, 'newPassword', ['class' => 'label']); ?>
                <?php echo Html::activePasswordInput($user, 'newPassword', [
                    'class' => 'textfield'.($user->hasErrors('newPassword')?' error':''),
                ]); ?>
            </div>
            <div class="w-full md:w-3/12 bloc-fieldset">
                <?php echo Html::activeLabel($user, 'checkPassword', ['class' => 'label']); ?>
                <?php echo Html::activePasswordInput($user, 'checkPassword', [
                    'class' => 'textfield'.($user->hasErrors('checkPassword')?' error':''),
                ]); ?>
            </div>
        </div>
        <?php if ($user->id !== null): ?>
        <div class="bloc">
            <div class="bloc-title">
                <span class="title">
                    <?php echo Module::t('user', 'Authorizations'); ?>
                </span>
                <span class="text-gray-200 italic text-xs"><?php echo Module::t('user', 'authorizations are updated on the fly'); ?></span>
            </div>
        </div>

        <?php echo Html::beginTag('div', [
            'class' => 'bloc',
            'blackcube-rbac' => \yii\helpers\Url::to(['rbac', 'id' => $user->id])]); ?>
            <?php echo $this->render('_roles', [
                'user' => $user,
                'userRolesById' => $userRolesById,
                'userPermissionsById' => $userPermissionsById,
                'userAssignmentsById' => $userAssignmentsById,
            ]); ?>
        <?php echo Html::endTag('div'); ?>
        <?php endif; ?>

        <div class="buttons">
            <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('user', 'Cancel'), ['index'], [
                'class' => 'button-cancel'
            ]); ?>
            <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('user', 'Save'), [
                'type' => 'submit',
                'class' => 'button-submit'
            ]); ?>
        </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
