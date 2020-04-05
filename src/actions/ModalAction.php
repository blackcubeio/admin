<?php

namespace blackcube\admin\actions;

use blackcube\core\models\Bloc;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use Yii;

class ModalAction extends Action
{
    public $elementClass;

    public $view = '_modal';

    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException();
        }
        if (Yii::$app->request->isAjax) {
            $elementClass = $this->elementClass;
            if ($id !== null) {
                $element = $elementClass::findOne(['id' => $id]);
                if ($element === null) {
                    throw new NotFoundHttpException();
                }
            } else {
                throw new NotFoundHttpException();
            }
            return $this->controller->renderPartial($this->view, ['element' => $element]);
        }

    }
}
