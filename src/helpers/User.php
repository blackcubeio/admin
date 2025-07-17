<?php
/**
 * User.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use Yii;

/**
 * Class User
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
