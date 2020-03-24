<?php

namespace blackcube\admin\commands;

use blackcube\admin\models\Administrator;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

class AdministratorController extends Controller
{

    public function actionCreate()
    {
        $this->stdout(Yii::t('blackcube.admin', 'Create new administrator'."\n"));
        $email = $this->prompt("\t".'email : ');
        $password = $this->prompt("\t".'password : ');
        $administrator = Yii::createObject(Administrator::class);
        $administrator->scenario = Administrator::SCENARIO_CREATE;
        $administrator->email = $email;
        $administrator->password = $password;
        $administrator->active = true;
        if ($administrator->validate() === true && $administrator->save() === true) {
            $this->stdout('Save administrator '.$administrator->email.' '.$administrator->password."\n");
        } else {
            $this->stdout('Administrator is invalid'."\n");
        }
        return ExitCode::OK;
    }
    public function actionUpdate()
    {
        $this->stdout('Administrator::update'."\n");
        return ExitCode::OK;
    }
    public function actionDelete()
    {
        $this->stdout('Administrator::delete'."\n");
        return ExitCode::OK;
    }
    public function actionList()
    {
        $this->stdout('Administrator::list'."\n");
        return ExitCode::OK;
    }
}
