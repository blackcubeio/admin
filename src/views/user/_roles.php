<?php
/**
 * _roles.php
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

$authManager = Yii::$app->authManager;

?>
<?php foreach($authManager->getRoles() as $i => $role): ?>
    <div class="w-full md:w-1/4 px-3 py-2">
        <label class="block w-full bg-gray-400 rounded py-1 px-2 select-none">
            <?php echo Html::checkbox(Rbac::rbac2Name($role->name), in_array($role->name, $userRolesById), [
                'data-rbac-type' => 'role',
                'data-rbac-name' => $role->name,
                'disabled' => (in_array($role->name, $userRolesById) && in_array($role->name, $userAssignmentsById) === false),
            ]); ?>
            <?php echo Rbac::extractRole($role->name); ?>
        </label>
        <div>
            <?php foreach($authManager->getChildRoles($role->name) as $childRole): ?>
                <?php if ($role->name !== $childRole->name): ?>
                    <label class="inline bg-white select-none italic text-xs">
                        <?php echo Rbac::extractRole($childRole->name); ?>
                    </label>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php if ($role->name !== Rbac::ROLE_ADMIN): ?>
        <?php foreach($authManager->getPermissionsByRole($role->name) as $permission): ?>
            <label class="block w-full bg-white py-0 px-2 select-none">
                <?php echo Html::checkbox(Rbac::rbac2Name($permission->name), in_array($permission->name, $userPermissionsById), [
                    'data-rbac-type' => 'permission',
                    'data-rbac-name' => $permission->name,
                    'disabled' => (in_array($permission->name, $userPermissionsById) && in_array($permission->name, $userAssignmentsById) === false),
                ]); ?>
                <?php echo Rbac::extractPermission($permission->name); ?>
            </label>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

