<?php

namespace blackcube\admin\widgets;

use yii\base\Widget;

class Topbar extends Widget
{
    public function run()
    {
        return $this->render('topbar', []);
    }
}
