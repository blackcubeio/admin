<?php

namespace blackcube\admin\widgets;

use yii\base\Widget;
use Yii;

class Sidebar extends Widget
{

    public function run()
    {
        return $this->render('sidebar', [
            'controller' => Yii::$app->controller->id,
        ]);
    }
}
