<?php

namespace blackcube\admin\actions;

use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use Yii;

class ModalAction extends Action
{
    public $elementClass;

    public $view = '@blackcube/admin/views/common/_modal';

    public function run($id = null)
    {
        if ($this->elementClass === null) {
            throw new InvalidArgumentException();
        }
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
