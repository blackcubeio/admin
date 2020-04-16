<?php
/**
 * BlocTypeController.php
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
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

/**
 * Class BlocTypeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class BlocTypeController extends Controller
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
                        'modal', 'index', 'create', 'edit', 'delete'
                    ],
                    'roles' => ['@'],
                ]
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
            'elementClass' => BlocType::class
        ];
        return $actions;
    }

    /**
     * @param null $id
     * @return string|Response
     */
    public function actionIndex($id = null)
    {
        $blocTypesQuery = BlocType::find()
            ->orderBy(['name' => SORT_ASC]);
        if ($id !== null) {
            $blocTypesQuery->andWhere(['id' => $id]);
        }
        return $this->render('index', [
            'blocTypesQuery' => $blocTypesQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $blocType = Yii::createObject(BlocType::class);
        $blocType->template = '{"type": "object", "properties": {"text": {"type": "string"}}, "required": []}';
        $typeBlocTypes = $this->getTypeBlocTypes();
        if (Yii::$app->request->isPost) {
            $blocType->load(Yii::$app->request->bodyParams);
            foreach($typeBlocTypes as $typeBlocType) {
                $typeBlocType->setScenario(TypeBlocType::SCENARIO_PRE_VALIDATE_TYPE);
            }
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($blocType->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                try {
                    if ($blocType->save()) {
                        foreach($typeBlocTypes as $typeBlocType) {
                            $typeBlocType->blocTypeId = $blocType->id;
                            $typeBlocType->save();
                        }
                        $transaction->commit();
                        return $this->redirect(['bloc-type/index']);
                    }
                    $transaction->rollBack();
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    throw $e;
                }
            }
        }
        return $this->render('form', [
            'blocType' => $blocType,
            'typeBlocTypes' => $typeBlocTypes,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEdit($id)
    {
        $blocType = BlocType::findOne(['id' => $id]);
        if ($blocType === null) {
            throw new NotFoundHttpException();
        }
        $typeBlocTypes = $this->getTypeBlocTypes($id);
        if (Yii::$app->request->isPost) {
            $blocType->load(Yii::$app->request->bodyParams);
            Model::loadMultiple($typeBlocTypes, Yii::$app->request->bodyParams);
            if ($blocType->validate() === true && Model::validateMultiple($typeBlocTypes)) {
                if ($blocType->save()) {
                    foreach($typeBlocTypes as $typeBlocType) {
                        $typeBlocType->save();
                    }
                    return $this->redirect(['bloc-type/index']);
                }
            }
        }
        return $this->render('form', [
            'blocType' => $blocType,
            'typeBlocTypes' => $typeBlocTypes,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $blocType = BlocType::findOne(['id' => $id]);
        if ($blocType === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $blocType->delete();
        }
        return $this->redirect(['bloc-type/index']);
    }

    /**
     * @param null $id
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    protected function getTypeBlocTypes($id = null)
    {
        $typeQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        $typeBlocTypes = [];
        foreach($typeQuery->each() as $type) {
            /* @var $type \blackcube\core\models\Type */
            $typeBlocType = null;
            if ($id !== null) {
                $typeBlocType = TypeBlocType::find()->where(['typeId' => $type->id, 'blocTypeId' => $id])->one();
            }
            if ($typeBlocType === null) {
                $typeBlocType = Yii::createObject(TypeBlocType::class);
                $typeBlocType->typeId = $type->id;
                $typeBlocType->blocTypeId = $id;
                $typeBlocType->allowed = false;
            }
            $typeBlocTypes[] = $typeBlocType;
        }
        return $typeBlocTypes;
    }
}
