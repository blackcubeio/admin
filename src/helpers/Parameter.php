<?php
/**
 * Parameter.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\core\models\Parameter as ParameterModel;

/**
 * Class Parameter
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class Parameter
{
    /**
     * @return array
     */
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
