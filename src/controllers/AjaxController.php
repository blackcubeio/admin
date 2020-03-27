<?php

namespace blackcube\admin\controllers;

use blackcube\core\models\Tag;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\AjaxFilter;
use Yii;

class AjaxController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['ajax'] = [
            'class' => AjaxFilter::class,
        ];
        return $behaviors;
    }
    public function actionModal($type = null, $id = null)
    {
        $name = null;
        if ($id !== null) {
            switch($type) {
                case 'tag':
                    $element = Tag::findOne(['id' => $id]);
                    break;
            }
            $name = ($element !== null) ? $element->name : null;
        }
        return $this->renderPartial('modal', [
            'name' => $name,
            'type' => $type,
        ]);
    }
}
