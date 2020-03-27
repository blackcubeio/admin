<?php

namespace blackcube\admin\actions;

use blackcube\core\models\Bloc;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use Yii;

class BlocAction extends Action
{
    public $elementClass;

    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException();
        }
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            $elementClass = $this->elementClass;
            if ($id !== null) {
                $element = $elementClass::findOne(['id' => $id]);
                if ($element === null) {
                    throw new NotFoundHttpException();
                }
            } else {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['blocAdd'])) {
                $bloc = new Bloc();
                $bloc->blocTypeId = Yii::$app->request->bodyParams['blocTypeId'];
                $bloc->save(false);
                $element->attachBloc($bloc, -1);
            } elseif (isset(Yii::$app->request->bodyParams['blocDelete'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocDelete']])->one();
                if ($bloc !== null) {
                    $element->detachBloc($bloc);
                }
            } elseif (isset(Yii::$app->request->bodyParams['blocUp'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocUp']])->one();
                $element->moveBlocUp($bloc);
            } elseif (isset(Yii::$app->request->bodyParams['blocDown'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocDown']])->one();
                $element->moveBlocDown($bloc);
            }
            $blocs = $element->getBlocs()->all();
            return $this->controller->renderPartial('_blocs', ['blocs' => $blocs]);
        }

    }
}