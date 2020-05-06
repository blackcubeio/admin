<?php
/**
 * InitController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\commands
 */

namespace blackcube\admin\commands;

use blackcube\admin\components\Rbac;
use blackcube\admin\interfaces\MenuInterface;
use blackcube\admin\interfaces\RbacableInterface;
use blackcube\admin\models\Administrator;
use blackcube\admin\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use ReflectionClass;
use Yii;

/**
 * Class InitController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\commands
 */
class InitController extends Controller
{

    /**
     * Update permissions and roles
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $this->stdout(Module::t('console', 'Init permissions and roles'."\n"));

        $authManager = Yii::$app->authManager;
        $modules = Module::getInstance()->getModules();
        $rbacClasses = [Rbac::class];
        foreach($modules as $id => $module) {
            if (is_array($module) === true) {
                $moduleClass = $module['class'];
            } else {
                $moduleClass = get_class($module);
            }
            if (is_subclass_of($moduleClass, RbacableInterface::class) === true) {
                $rbacClasses[] = $moduleClass::getRbacClass();
            }
        }
        $roles = [];
        $permissions = [];
        foreach ($rbacClasses as $rbacClass) {
            $originalRights = new ReflectionClass($rbacClass);
            foreach ($originalRights->getConstants() as $name => $value) {
                if (strncmp($name, 'PERMISSION_', 11) === 0) {
                    $permissions[] = $value;
                    $permission = $authManager->getPermission($value);
                    if ($permission === null) {
                        $permission = $authManager->createPermission($value);
                        $authManager->add($permission);
                    }
                } elseif (strncmp($name, 'ROLE_', 5) === 0) {
                    $roles[] = $value;
                    $role = $authManager->getRole($value);
                    if ($role === null) {
                        $role = $authManager->createRole($value);
                        $authManager->add($role);
                    }
                }
            }
            foreach($roles as $role) {
                if (strpos($role, ':') !== false) {
                    list($roleType, $roleKind) = explode(':', $role);
                    foreach($permissions as $permission) {
                        if (strpos($permission, ':') !== false) {
                            list($permissionType, $permissionKind) = explode(':', $permission);
                            if ($roleType === $permissionType) {
                                $realRole = $authManager->getRole($role);
                                $realPermission = $authManager->getPermission($permission);

                                if ($authManager->canAddChild($realRole, $realPermission) && $authManager->hasChild($realRole, $realPermission) === false) {
                                    $authManager->addChild($realRole, $realPermission);
                                }
                            }
                        }
                    }
                } elseif ($role === Rbac::ROLE_ADMIN) {
                    $currentRole = Yii::$app->authManager->getRole($role);
                    foreach ($roles as $innerRole) {
                        $realRole = $authManager->getRole($innerRole);
                        if ($authManager->canAddChild($currentRole, $realRole) && $authManager->hasChild($currentRole, $realRole) === false) {
                            $authManager->addChild($currentRole, $realRole);
                        }
                    }
                }
            }
        }
        $existingRoles = $authManager->getRoles();
        foreach($existingRoles as $existingRole) {
            if (in_array($existingRole->name, $roles) === false) {
                $authManager->remove($existingRole);
            }
        }
        $existingPermissions = $authManager->getPermissions();
        foreach($existingPermissions as $existingPermission) {
            if (in_array($existingPermission->name, $permissions) === false) {
                $authManager->remove($existingPermission);
            }
        }

        return ExitCode::OK;
    }
}
