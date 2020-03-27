<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\Administrator;
use yii\web\Controller;
use Yii;

class AuthenticationController extends Controller
{
    public $layout = 'main-login';

    public function actionLogin()
    {
        $administrator = Yii::createObject(Administrator::class);
        /* @var $administrator Administrator */
        $administrator->scenario = Administrator::SCENARIO_LOGIN;
        if ($administrator->load(Yii::$app->request->bodyParams) === true) {
            if ($administrator->validate() === true) {
                $realAdministrator = Administrator::find()->where(['email' => $administrator->email])->one();
                // $realAdministrator = $administrator::
            }
        }
        return $this->render('login', [
            'administrator' => $administrator
        ]);
    }
}