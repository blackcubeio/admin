<?php
/**
 * User.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use Yii;

/**
 * Class User
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

class User {
    /**
     * @param integer $userId
     * @return array
     */
    public static function prepareAuthorizationData($userId)
    {
        $authManager = Yii::$app->authManager;
        $userRoles = $authManager->getRolesByUser($userId);
        $userChildRoles = [];
        foreach($userRoles as $userRole) {
            $userChildRoles = array_merge($userChildRoles, $authManager->getChildRoles($userRole->name));
        }
        $userRolesById = array_map(function($role) {
            /* @var $role \yii\rbac\Role */
            return $role->name;
        }, $userChildRoles);
        $userPermissions = $authManager->getPermissionsByUser($userId);
        $userPermissionsById = array_map(function($permission) {
            /* @var $permission \yii\rbac\Permission */
            return $permission->name;
        }, $userPermissions);

        $userAssignments = $authManager->getAssignments($userId);
        $userAssignmentsById = array_map(function($assignment) {
            /* @var $assignment \yii\rbac\Assignment */
            return $assignment->roleName;
        }, $userAssignments);
        return [
            'userRolesById' => $userRolesById,
            'userPermissionsById' => $userPermissionsById,
            'userAssignmentsById' => $userAssignmentsById,
        ];
    }

}
