<?php
/**
 * _roles.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $user \blackcube\admin\models\Administrator
 * @var $userRolesById array
 * @var $userPermissionsById array
 * @var $userAssignmentsById array
 * @var $updated boolean
 * @var $canAssign boolean
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;

$authManager = Yii::$app->authManager;
$additionalOptions = [];
if ($updated) {
    $additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
        'title.bind' => Module::t('user', 'Success'),
        'type.bind' => 'check',
        'content.bind' => Module::t('user', 'Permission were updated'),
    ]);
}
?>
<?php echo Html::beginTag('div', ['class' => 'px-6 pb-6'] + $additionalOptions); ?>

    <div class="element-form-bloc-grid-12">
<?php foreach($authManager->getRoles() as $i => $role): ?>
    <div class="element-form-bloc-cols-4 border-indigo-800 border-2 rounded">
        <div class="px-2 pt-2 pb-3 bg-indigo-100 border-b-2 border-indigo-800">
            <?php
            $parameters = [
                'label' => Rbac::extractRole($role->name),
                'data-rbac-type' => 'role',
                'data-rbac-name' => $role->name,
            ];
            if ((in_array($role->name, $userRolesById) && in_array($role->name, $userAssignmentsById) === false)) {
                $parameters['disabled'] = 'disabled';
                $parameters['readonly'] = 'readonly';
            }
            if ($canAssign === false) {
                $parameters['disabled'] = 'disabled';
                $parameters['readonly'] = 'readonly';
            }
            ?>
            <?php echo BlackcubeHtml::checkbox(Rbac::rbac2Name($role->name), in_array($role->name, $userRolesById), $parameters); ?>
            <?php // echo Rbac::extractRole($role->name); ?>
        </div>
        <?php if (count($authManager->getChildRoles($role->name)) > 1): ?>
        <div class="p-2">
            <?php foreach($authManager->getChildRoles($role->name) as $childRole): ?>
                <?php if ($role->name !== $childRole->name): ?>
                    <label class="inline bg-white select-none italic text-xs">
                        <?php echo Rbac::extractRole($childRole->name); ?>
                    </label>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php if ($role->name !== Rbac::ROLE_ADMIN): ?>
        <div class="p-2">
        <?php foreach($authManager->getPermissionsByRole($role->name) as $permission): ?>
                <div class="">
                    <?php
                    $parameters = [
                        'label' => Rbac::extractPermission($permission->name),
                        'data-rbac-type' => 'permission',
                        'data-rbac-name' => $permission->name,
                    ];
                    if ((in_array($permission->name, $userPermissionsById) && in_array($permission->name, $userAssignmentsById) === false)) {
                        $parameters['disabled'] = 'disabled';
                        $parameters['readonly'] = 'readonly';
                    }
                    if ($canAssign === false) {
                        $parameters['disabled'] = 'disabled';
                        $parameters['readonly'] = 'readonly';
                    }
                    ?>
                    <?php echo BlackcubeHtml::checkbox(Rbac::rbac2Name($permission->name), in_array($permission->name, $userPermissionsById), $parameters); ?>
                    <?php // echo Rbac::extractRole($role->name); ?>
                </div>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
    </div>
<?php echo Html::endTag('div'); ?>