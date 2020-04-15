<?php

namespace blackcube\admin\models;

use yii\db\ActiveQuery;
use yii\db\Expression;
use Yii;

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
