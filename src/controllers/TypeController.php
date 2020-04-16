<?php
/**
 * TypeController.php
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

use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\models\BlocType;
use blackcube\core\models\Type;
use blackcube\core\models\TypeBlocType;
use blackcube\core\Module as CoreModule;
use blackcube\core\web\controllers\BlackcubeController;
use yii\base\ErrorException;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class TypeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class TypeController extends Controller
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
                        'modal', 'index', 'create', 'edit', 'delete', 'actions',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'actions'],
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
            'elementClass' => Type::class
        ];
        return $actions;
    }

    /**
     * @param string|null $id
     * @return string
     */
    public function actionIndex($id = null)
    {
        $typesQuery = Type::find()
            ->orderBy(['name' => SORT_ASC]);
        if ($id !== null) {
            $typesQuery->andWhere(['id' => $id]);
        }
        return $this->render('index', [
            'typesQuery' => $typesQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $type = Yii::createObject(Type::class);
        $typeBlocTypes = $this->getTypeBlocTypes();
        if (Yii::$app->request->isPost) {
            $type->load(Yii::$app->request->bodyParams);
            if ($type->action === 'default') {
                $type->action = null;
            }
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($type->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                try {
                    $typeStatus = $type->save();
                    if ($typeStatus === true) {
                        $status = true;
                        foreach ($typeBlocTypes as $typeBlocType) {
                            $typeBlocType->setScenario(TypeBlocType::SCENARIO_DEFAULT);
                            $typeBlocType->typeId = $type->id;
                            $status = $status && $typeBlocType->save();
                        }
                        if ($typeStatus && $status) {
                            $transaction->commit();
                            return $this->redirect(['type/index']);
                        }
                    }
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('form', [
            'type' => $type,
            'typeBlocTypes' => $typeBlocTypes,
            'controllers' => $this->findControllers(),
            'actions' => $this->findActions($type->controller)
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \ReflectionException
     */
    public function actionEdit($id)
    {
        $type = Type::findOne(['id' => $id]);
        if ($type === null) {
            throw new NotFoundHttpException();
        }
        $typeBlocTypes = $this->getTypeBlocTypes($id);
        if (Yii::$app->request->isPost) {
            $type->load(Yii::$app->request->bodyParams);
            if ($type->action === 'default') {
                $type->action = null;
            }
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($type->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                if ($type->save()) {
                    foreach ($typeBlocTypes as $typeBlocType) {
                        $typeBlocType->save();
                    }
                    return $this->redirect(['index']);
                }
            }
        }
        return $this->render('form', [
            'type' => $type,
            'typeBlocTypes' => $typeBlocTypes,
            'controllers' => $this->findControllers(),
            'actions' => $this->findActions($type->controller)
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $type = Type::findOne(['id' => $id]);
        if ($type === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $type->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer|null $id
     * @return TypeBlocType[]
     * @throws \yii\base\InvalidConfigException
     */
    protected function getTypeBlocTypes($id = null)
    {
        $blocTypesQuery = BlocType::find()->orderBy(['name' => SORT_ASC]);
        $typeBlocTypes = [];
        foreach($blocTypesQuery->each() as $blocType) {
            /* @var $blocType \blackcube\core\models\BlocType */
            $typeBlocType = null;
            if ($id !== null) {
                $typeBlocType = TypeBlocType::find()->where(['typeId' => $id, 'blocTypeId' => $blocType->id])->one();
            }
            if ($typeBlocType === null) {
                $typeBlocType = Yii::createObject(TypeBlocType::class);
                if ($id === null) {
                    $typeBlocType->setScenario(TypeBlocType::SCENARIO_PRE_VALIDATE_BLOCTYPE);
                }
                $typeBlocType->typeId = $id;
                $typeBlocType->blocTypeId = $blocType->id;
                $typeBlocType->allowed = false;
            }
            $typeBlocTypes[] = $typeBlocType;
        }
        return $typeBlocTypes;
    }

    /**
     * @param $controller
     * @return array
     * @throws MethodNotAllowedHttpException
     */
    public function actionActions($controller)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $this->findActions($controller);
    }

    /**
     * @param null $controller
     * @return array
     */
    protected function findActions($controller = null)
    {
        $actions = [];
        $actions[] = [
            'id' => 'default',
            'name' => '*'
        ];
        if ($controller !== null) {
            try {
                $controllerNamespace = CoreModule::getInstance()->cmsControllerNamespace;
                $controllerClass = $controllerNamespace.'\\'.$controller.'Controller';
                $ref = new \ReflectionClass($controllerClass);
                foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                    if (strncmp('action', $method->name, 6) === 0 && ($method->name !== 'actions')) {
                        $realMethod = str_replace('action', '', $method->name);
                        $actions[] = [
                            'id' => Inflector::camel2id($realMethod),
                            'name' => Inflector::camel2id($realMethod),
                        ];
                    }
                }
                if ($ref->hasMethod('actions')) {
                    $currentController = $ref->newInstanceWithoutConstructor();
                    $externalActions = $currentController->actions();
                    foreach($externalActions as $id => $config) {
                        $actions[] = [
                            'id' => $id,
                            'name' => $id
                        ];
                    }

                }
            } catch (\Exception $e) {

            }
        }
        return $actions;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    protected function findControllers()
    {
        $controllerNamespace = CoreModule::getInstance()->cmsControllerNamespace;
        $controllerAlias = '@'.str_replace('\\', '/', $controllerNamespace);
        $controllerPath = Yii::getAlias($controllerAlias);
        $files = scandir($controllerPath);
        $controllers = [];
        $controllers[] = [
            'id' => CoreModule::getInstance()->cmsDefaultController,
            'name' => '*'
        ];
        foreach($files as $file) {
            if (preg_match('/^((.+)Controller).php$/', $file, $matches) > 0) {
                if ($matches[2] !== 'Blackcube') {
                    $targetClass = $controllerNamespace.'\\'.$matches[1];
                    $ref = new \ReflectionClass($targetClass);
                    if ($ref->isSubclassOf(BlackcubeController::class) && $ref->isAbstract() === false) {
                        $controllers[] = [
                            'id' => $matches[2],
                            'name' => Inflector::camel2id($matches[2]),
                        ];
                    }

                }
            }
        }
        return $controllers;
    }
}
