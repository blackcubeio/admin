<?php

namespace blackcube\admin\controllers;

use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\models\BlocType;
use blackcube\core\models\Type;
use blackcube\core\models\TypeBlocType;
use yii\base\Model;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class BlocTypeController extends Controller
{

    public function actions()
    {
        $actions = parent::actions();
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => BlocType::class
        ];
        return $actions;
    }

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
