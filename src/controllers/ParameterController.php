<?php
/**
 * ParameterController.php
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
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Parameter;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

/**
 * Class ParameterController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class ParameterController extends Controller
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
                        'modal', 'index',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal'],
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
            'elementClass' => Parameter::class
        ];
        return $actions;
    }

    /**
     * @param null $id
     * @return string|Response
     */
    public function actionIndex()
    {
        $parametersQuery = Parameter::find()
            ->orderBy(['domain' => SORT_ASC, 'name' => SORT_ASC]);
        return $this->render('index', [
            'parametersQuery' => $parametersQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $parameter = Yii::createObject(Parameter::class);
        if (Yii::$app->request->isPost) {
            $parameter->load(Yii::$app->request->bodyParams);
            if ($parameter->validate() === true) {
                if ($parameter->save()) {
                    return $this->redirect(['edit', 'domain' => $parameter->domain, 'name' => $parameter->name]);
                }
            }
        }
        return $this->render('form', [
            'parameter' => $parameter,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEdit($domain, $name)
    {
        $parameter = Parameter::findOne(['domain' => $domain, 'name' => $name]);
        if ($parameter === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $parameter->load(Yii::$app->request->bodyParams);
            if ($parameter->validate() === true) {
                if ($parameter->save()) {
                    return $this->redirect(['edit', 'domain' => $parameter->domain, 'name' => $parameter->name]);
                }
            }
        }
        return $this->render('form', [
            'parameter' => $parameter,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($domain, $name)
    {
        $parameter = Parameter::findOne(['domain' => $domain, 'name' => $name]);
        if ($parameter === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $parameter->delete();
        }
        return $this->redirect(['index']);
    }
}
