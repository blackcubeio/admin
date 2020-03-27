<?php

namespace blackcube\admin\helpers;

use blackcube\core\models\Parameter as ParameterModel;

class Parameter
{
    public static function getAllowedHosts()
    {
        $parameters = ParameterModel::find()
            ->andWhere(['domain' => 'HOSTS'])
            ->select(['value'])
            ->orderBy(['name' => SORT_ASC])
            ->asArray()
            ->all();
        $allowedHosts = array_map(function($item) {
            return [
                'id' => $item['value'] === '*' ? '' : $item['value'],
                'value' => $item['value'],
            ];
        }, $parameters);
        array_unshift($allowedHosts, ['id' => '', 'value' => '*']);
        return $allowedHosts;
    }
}
