<?php
/**
 * Route.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\models\NodeComposite;
use blackcube\core\Module as CoreModule;
use blackcube\core\interfaces\BlackcubeControllerInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use yii\helpers\Inflector;
use yii\web\Controller;
use Yii;

/**
 * Class Route
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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
                    Yii::error(Module::t('helpers', 'Module "{moduleId}" does not exist.', ['moduleId' => $moduleId]));
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
                                    // $routes[$route] = $route;
                                    $routes[] = [
                                        'id' => '/'.$route,
                                        'name' => $route,
                                        'type' => Module::t('helpers', 'Blackcube')
                                    ];
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
                                    // $routes[$route] = $route;
                                    $routes[] = [
                                        'id' => '/'.$route,
                                        'name' => $route,
                                        'type' => Module::t('helpers', 'Blackcube')
                                    ];
                                }

                            }

                        }
                    }
                }
            }
        }
        usort($routes, function($item1, $item2) {
            if ($item1['type'] === $item2['type']) {
                if ($item1['name'] === $item2['name']) {
                    return 0;
                } elseif ($item1['name'] > $item2['name']) {
                    return 1;
                } else {
                    return -1;
                }
            } elseif ($item1['type'] > $item2['type']) {
                return 1;
            } else {
                return -1;
            }
        });
        return $routes;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    public static function findAllRoutes()
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
                    Yii::error(Module::t('helpers', 'Module "{moduleId}" does not exist.', ['moduleId' => $moduleId]));
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
                        if (($ref->isSubclassOf(Controller::class) || $ref->implementsInterface(BlackcubeControllerInterface::class)) && $ref->isAbstract() === false) {
                            // this is a "regular" or a "cms" controller
                            $defaultAction = $ref->getProperty('defaultAction')->getValue($ref->newInstanceWithoutConstructor());
                            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                                if (strncmp('action', $method->name, 6) === 0 && ($method->name !== 'actions')) {
                                    $realMethod = str_replace('action', '', $method->name);
                                    $actionId = Inflector::camel2id($realMethod);
                                    if ($actionId === $defaultAction) {
                                        $actionId = $defaultAction;
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' => Module::t('helpers', 'Regular')];
                                }
                            }
                            if ($ref->hasMethod('actions')) {
                                $currentController = $ref->newInstanceWithoutConstructor();
                                $externalActions = $currentController->actions();
                                foreach($externalActions as $actionId => $config) {
                                    if ($actionId === $defaultAction) {
                                        $actionId = $defaultAction;
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' =>  Module::t('helpers', 'Regular')];
                                }

                            }
                        }
                    }
                }
            }
        }
        usort($routes, function($item1, $item2) {
            if ($item1['type'] === $item2['type']) {
                if ($item1['name'] === $item2['name']) {
                    return 0;
                } elseif ($item1['name'] > $item2['name']) {
                    return 1;
                } else {
                    return -1;
                }
            } elseif ($item1['type'] > $item2['type']) {
                return 1;
            } else {
                return -1;
            }
        });

        $compositeRoutes = [];
        $nodeQuery = Node::find()
            ->joinWith(['slug'])
            ->orderBy(['left' => SORT_ASC]);
        foreach ($nodeQuery->each() as $node) {
            if ($node->slug !== null) {
                $routes[] = [
                    'id' => $node->getRoute(),
                    'name' => str_repeat('  ', $node->level - 1).' '.$node->name.' ('.$node->languageId.')',
                    'type' => Module::t('helpers', 'CMS Node')
                ];
            }
            foreach ($node->getComposites()->each() as $composite) {
                if ($composite->slug !== null) {
                    $compositeRoutes[] = [
                        'id' => $composite->getRoute(),
                        'name' => $composite->name.' ('.$composite->languageId.')',
                        'type' => Module::t('helpers', 'CMS Composite - {node}', ['node' => $node->name.' ('.$node->languageId.')'])
                    ];
                }
            }
        }
        $routes = array_merge($routes, $compositeRoutes);
        unset($compositeRoutes);

        $compositeQuery = Composite::find()
            ->orphan()
            ->joinWith(['slug'])
            ->orderBy(['name' => SORT_ASC]);
        foreach ($compositeQuery->each() as $composite) {
            if ($composite->slug !== null) {
                $routes[] = [
                    'id' => $composite->getRoute(),
                    'name' => $composite->name.' ('.$composite->languageId.')',
                    'type' => Module::t('helpers', 'CMS Composite - Orphans')
                ];
            }
        }

        $categoryQuery = Category::find()
            ->joinWith(['slug'])
            ->orderBy(['name' => SORT_ASC]);
        foreach ($categoryQuery->each() as $category) {
            if ($node->slug !== null) {
                $routes[] = [
                    'id' => $category->getRoute(),
                    'name' => $category->name.' ('.$category->languageId.')',
                    'type' => Module::t('helpers', 'CMS Category')
                ];
            }
        }
        $tagQuery = Tag::find()
            ->joinWith(['slug'])
            ->orderBy(['name' => SORT_ASC]);
        foreach ($tagQuery->each() as $tag) {
            if ($tag->slug !== null) {
                $routes[] = [
                    'id' => $tag->getRoute(),
                    'name' => $tag->name.' ('.$tag->category->languageId.')',
                    'type' => Module::t('helpers', 'CMS Tag')];
            }
        }


        return $routes;

    }
}
