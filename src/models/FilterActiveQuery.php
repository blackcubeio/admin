<?php

namespace blackcube\admin\models;

use yii\db\ActiveQuery;
use Yii;
use yii\db\Expression;

class FilterActiveQuery extends ActiveQuery
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function active() {
        $this->andWhere([
            '[[active]]' => true,
        ]);
        return $this;
    }
}
