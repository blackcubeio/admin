<?php

namespace blackcube\admin\actions;

use blackcube\core\models\Bloc;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use Yii;

class BlocAction extends Action
{
    public $elementClass;

    public $view = '@blackcube/admin/views/common/_blocs';

    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException();
        }
        if (Yii::$app->request->isPost) {
            $elementClass = $this->elementClass;
            if ($id !== null) {
                $element = $elementClass::findOne(['id' => $id]);
                if ($element === null) {
                    throw new NotFoundHttpException();
                }
            } else {
                throw new NotFoundHttpException();
            }
            $originalBlocs = $element->getBlocs()->all();
            Model::loadMultiple($originalBlocs, Yii::$app->request->bodyParams);
            if (isset(Yii::$app->request->bodyParams['blocAdd'])) {
                $bloc = Yii::createObject(Bloc::class);
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
                if ($bloc !== null) {
                    $element->moveBlocUp($bloc);
                }
            } elseif (isset(Yii::$app->request->bodyParams['blocDown'])) {
                $bloc = Bloc::find()->andWhere(['id' => Yii::$app->request->bodyParams['blocDown']])->one();
                if ($bloc !== null) {
                    $element->moveBlocDown($bloc);
                }
            }
            $blocs = $element->getBlocs()->all();
            foreach($blocs as $bloc) {
                foreach ($originalBlocs as $originalBloc) {
                    if ($bloc->id == $originalBloc->id) {
                        $bloc->attributes = $originalBloc->attributes;
                        break;
                    }
                }
            }
            return $this->controller->renderPartial($this->view, ['blocs' => $blocs, 'element' => $element]);
        }

    }
}
