<?php
/**
 * MenuController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\ToggleAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use blackcube\core\Module as CoreModule;
use blackcube\core\interfaces\BlackcubeControllerInterface;
use blackcube\core\models\Language;
use blackcube\core\models\Menu;
use blackcube\core\models\MenuItem;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class MenuController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class MenuController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'modal', 'item-modal', 'index',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'edit-item', 'create-item', 'up-item', 'down-item'
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete', 'delete-item',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'item-modal', 'toggle', 'up-item', 'down-item'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Menu::class
        ];
        $actions['item-modal'] = [
            'class' => ModalAction::class,
            'elementClass' => MenuItem::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Menu::class,
            'elementName' => 'menu',
        ];
        return $actions;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $menusQuery = Menu::find();
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $menusQuery->andWhere(['or',
                ['like', Menu::tableName().'.[[name]]', $search],
            ]);
        }
        $menusProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $menusQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC
                ],
                'attributes' => [
                    'name',
                    'active',
                ]
            ],
        ]);
        return $this->render('index', [
            'menusProvider' => $menusProvider
        ]);
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $menu = Yii::createObject(Menu::class);
        if (Yii::$app->request->isPost === true) {
            $menu->load(Yii::$app->request->bodyParams);
            if ($menu->validate() === true) {
                if ($menu->save() === true) {
                    return $this->redirect(['edit', 'id' => $menu->id]);
                }
            }
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => null,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id)
    {
        $menu = Menu::findOne(['id' => $id]);
        if ($menu === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost === true) {
            $menu->load(Yii::$app->request->bodyParams);
            if ($menu->validate() === true) {
                if ($menu->save() === true) {
                    return $this->redirect(['edit', 'id' => $menu->id]);
                }
            }
        }
        $menuItemsQuery = $menu->getChildren();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }

    /**
     * @param integer $menuId
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreateItem($menuId)
    {
        $menu = Menu::findOne(['id' => $menuId]);
        if ($menu === null) {
            throw new NotFoundHttpException();
        }
        $menuItem = Yii::createObject(MenuItem::class);
        $menuItem->menuId = $menuId;
        if (Yii::$app->request->isPost) {
            $menuItem->load(Yii::$app->request->bodyParams);
            if ($menuItem->validate() === true) {
                $menuItem->order = 999;
                try {
                    $transaction = MenuItem::getDb()->beginTransaction();
                    if ($menuItem->save() === true) {
                        MenuItem::reorder($menu->id);
                        $transaction->commit();
                        $this->redirect(['edit', 'id' => $menu->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        $parentsQuery = MenuItem::find()->andWhere(['menuId' => $menu->id]);
        return $this->render('form_item', [
            'menuItem' => $menuItem,
            'parentsQuery' => $parentsQuery,
            'routes' => $this->findRoutes(),
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionEditItem($id)
    {
        $menuItem = MenuItem::findOne(['id' => $id]);
        if ($menuItem === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $menuItem->load(Yii::$app->request->bodyParams);
            if ($menuItem->validate() === true) {
                $dirtyAttributes = $menuItem->getDirtyAttributes();
                if (isset($dirtyAttributes['parentId']) === true) {
                    $reorder = true;
                    $menuItem->order = 999;
                } else {
                    $reorder = false;
                }
                try {
                    $transaction = MenuItem::getDb()->beginTransaction();
                    if ($menuItem->save() === true) {
                        if ($reorder === true) {
                            MenuItem::reorder($menuItem->menu->id);
                        }
                        $transaction->commit();
                        $this->redirect(['edit', 'id' => $menuItem->menu->id]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }

        }
        $parentsQuery = MenuItem::find()->andWhere(['menuId' => $menuItem->menuId])
            ->andWhere(['!=', 'id', $menuItem->id ]);
        return $this->render('form_item', [
            'menuItem' => $menuItem,
            'parentsQuery' => $parentsQuery,
            'routes' => $this->findRoutes(),
        ]);
    }

    /**
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $menu = Menu::findOne(['id' => $id]);
        if ($menu === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $menu->delete();
        }
        return $this->redirect(['index']);
    }



    /**
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteItem($id)
    {
        $menuItem = MenuItem::findOne(['id' => $id]);
        if ($menuItem === null) {
            throw new NotFoundHttpException();
        }
        $menuId = $menuItem->menu->id;
        if (Yii::$app->request->isPost) {
            $menuItem->delete();
            MenuItem::reorder($menuId);
        }
        return $this->redirect(['edit', 'id' => $menuId]);
    }

    /**
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionUpItem($id)
    {
        $menuItem = MenuItem::findOne(['id' => $id]);
        if ($menuItem === null) {
            throw new NotFoundHttpException();
        }
        $previousItem = MenuItem::find()
            ->andWhere(['parentId' => $menuItem->parentId])
            ->andWhere(['<', 'order', $menuItem->order])
            ->orderBy(['order' => SORT_DESC])
            ->one();
        $menu = $menuItem->menu;
        if ($previousItem !== null) {
            $previousOrder = $previousItem->order;
            $previousItem->order = $menuItem->order;
            $menuItem->order = $previousOrder;
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $menuItem->save(false, ['order', 'dateUpdate']);
                $previousItem->save(false, ['order', 'dateUpdate']);
                MenuItem::reorder($menu->id);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        $menuItemsQuery = $menu->getChildren();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->renderPartial('_form_list', [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return Response|string
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDownItem($id)
    {
        $menuItem = MenuItem::findOne(['id' => $id]);
        if ($menuItem === null) {
            throw new NotFoundHttpException();
        }
        $nextItem = MenuItem::find()
            ->andWhere(['parentId' => $menuItem->parentId])
            ->andWhere(['>', 'order', $menuItem->order])
            ->orderBy(['order' => SORT_ASC])
            ->one();
        $menu = $menuItem->menu;
        if ($nextItem !== null) {
            $nextOrder = $nextItem->order;
            $nextItem->order = $menuItem->order;
            $menuItem->order = $nextOrder;
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $menuItem->save(false, ['order', 'dateUpdate']);
                $nextItem->save(false, ['order', 'dateUpdate']);
                MenuItem::reorder($menu->id);
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        $menuItemsQuery = $menu->getChildren();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        return $this->renderPartial('_form_list', [
            'menu' => $menu,
            'languagesQuery' => $languagesQuery,
            'menuItemsQuery' => $menuItemsQuery,
        ]);
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function findRoutes()
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
                    Yii::error(Module::t('menu', 'Module "{moduleId}" does not exist.', ['moduleId' => $moduleId]));
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
                            /*/
                            $defaultAction = $ref->getProperty('defaultAction')->getValue($ref->newInstanceWithoutConstructor());
                            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                                if (strncmp('action', $method->name, 6) === 0 && ($method->name !== 'actions')) {
                                    $realMethod = str_replace('action', '', $method->name);
                                    $actionId = Inflector::camel2id($realMethod);
                                    if ($actionId === $defaultAction) {
                                        $actionId = '';
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' => 'cms'];
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
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' => 'cms'];
                                }

                            }
                            /**/
                        } elseif (/**/$ref->isSubclassOf(Controller::class) && /**/ $ref->isAbstract() === false) {
                            $defaultAction = $ref->getProperty('defaultAction')->getValue($ref->newInstanceWithoutConstructor());
                            foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                                if (strncmp('action', $method->name, 6) === 0 && ($method->name !== 'actions')) {
                                    $realMethod = str_replace('action', '', $method->name);
                                    $actionId = Inflector::camel2id($realMethod);
                                    if ($actionId === $defaultAction) {
                                        $actionId = '';
                                    }
                                    $route = trim($info['moduleId'].'/'.$controllerId.'/'.$actionId, '/');
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' => Module::t('menu', 'Regular')];
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
                                    $routes[] = ['id' => $route, 'name' => $route, 'type' =>  Module::t('menu', 'Regular')];
                                }

                            }
                        }
                    }
                }
            }
        }
        $nodeQuery = Node::find()->joinWith(['slug'])->orderBy(['left' => SORT_ASC]);
        foreach ($nodeQuery->each() as $node) {
            if ($node->slug !== null) {
                $routes[] = ['id' => $node->getRoute(), 'name' => $node->name, 'type' => Module::t('menu', 'CMS Node')];
            }
        }
        $compositeQuery = Composite::find()->joinWith(['slug'])->orderBy(['name' => SORT_ASC]);
        foreach ($compositeQuery->each() as $composite) {
            if ($composite->slug !== null) {
                $routes[] = ['id' => $composite->getRoute(), 'name' => $composite->name, 'type' => Module::t('menu', 'CMS Composite')];
            }
        }
        $categoryQuery = Category::find()->joinWith(['slug'])->orderBy(['name' => SORT_ASC]);
        foreach ($categoryQuery->each() as $category) {
            if ($node->slug !== null) {
                $routes[] = ['id' => $category->getRoute(), 'name' => $category->name, 'type' => Module::t('menu', 'CMS Category')];
            }
        }
        $tagQuery = Tag::find()->joinWith(['slug'])->orderBy(['name' => SORT_ASC]);
        foreach ($tagQuery->each() as $tag) {
            if ($tag->slug !== null) {
                $routes[] = ['id' => $tag->getRoute(), 'name' => $tag->name, 'type' => Module::t('menu', 'CMS Tag')];
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
}
