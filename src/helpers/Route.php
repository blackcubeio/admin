<?php
/**
 * Route.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\Module as CoreModule;
use blackcube\core\interfaces\BlackcubeControllerInterface;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\NodeComposite;
use Yii;
use yii\helpers\Inflector;

/**
 * Class Route
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

class Route {
    public static function findRoutes()
    {
        $modulesAllowed = CoreModule::getInstance()->cmsEnabledmodules;
        $controllerPaths = [];
        foreach($modulesAllowed as $moduleId) {
            $controllerPath = null;
            $controllerNS = null;
            if (empty($moduleId) === true) {
                $controllerPath = Yii::$app->controllerPath;
                $controllerNS = Yii::$app->controllerNamespace;
            } else {
                try {
                    $realModule = Yii::$app->getModule($moduleId);
                    if ($realModule !== null) {
                        $controllerPath = $realModule->controllerPath;
                        $controllerNS = $realModule->controllerNamespace;
                    }
                } catch(\Exception $e) {
                    Yii::error(Module::t('type', 'Module "{moduleId}" does not exist.', ['moduleId' => $moduleId]));
                }
            }
            if ($controllerPath !== null && $controllerNS !== null) {
                $controllerPaths[] = [
                    'moduleId' => $moduleId,
                    'path' => $controllerPath,
                    'namespace' => $controllerNS,
                ];
            }
        }
        $routes = [];
        foreach($controllerPaths as $info) {
            $files = scandir($info['path']);
            foreach($files as $file) {
                if (preg_match('/^((.+)Controller).php$/', $file, $matches) > 0) {
                    if ($matches[2] !== 'Blackcube') {
                        $controllerId = Inflector::camel2id($matches[2]);
                        $targetClass = $info['namespace'].'\\'.$matches[1];
                        $ref = new \ReflectionClass($targetClass);
                        if (/**/$ref->implementsInterface(BlackcubeControllerInterface::class) && /**/ $ref->isAbstract() === false) {
                            $defaultAction = $ref->getProperty('defaultAction')->getValue($ref->newInstanceWithoutConstructor());
                            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                                if (strncmp('action', $method->name, 6) === 0 && ($method->name !== 'actions')) {
                                    $realMethod = str_replace('action', '', $method->name);
                                    $actionId = Inflector::camel2id($realMethod);
                                    if ($actionId === $defaultAction) {
                                        $actionId = '';
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[$route] = $route;
                                }
                            }
                            if ($ref->hasMethod('actions')) {
                                $currentController = $ref->newInstanceWithoutConstructor();
                                $externalActions = $currentController->actions();
                                foreach($externalActions as $actionId => $config) {
                                    if ($actionId === $defaultAction) {
                                        $actionId = '';
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[$route] = $route;
                                }

                            }

                        }
                    }
                }
            }
        }
        return $routes;
    }
}
