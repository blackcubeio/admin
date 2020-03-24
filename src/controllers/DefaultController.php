<?php

namespace blackcube\admin\controllers;

use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index', []);
    }
    public function actionTest()
    {
        return $this->render('test', []);
    }
}
