<?php

namespace blackcube\admin\widgets;

use yii\base\Widget;

class Nav extends Widget
{
    public function run()
    {
        return $this->render('nav', []);
    }
}