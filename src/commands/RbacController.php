<?php

namespace blackcube\admin\commands;

use blackcube\admin\components\RbacConstants;
use blackcube\admin\models\Administrator;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use ReflectionClass;

class RbacController extends Controller
{

    public function actionInit()
    {
        $originalRights = new ReflectionClass(RbacConstants::class);
        // Yii::$app->
        foreach ($originalRights->getConstants() as $name => $value) {
            if (strncmp($name, 'PERMISSION_', 11) === 0) {

            }
        }
        return ExitCode::OK;
    }
}
