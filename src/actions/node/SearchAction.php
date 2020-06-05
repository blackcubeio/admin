<?php
/**
 * SearchAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\actions\BaseElementAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class SearchAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class SearchAction extends BaseElementAction
{

    /**
     * @param string query
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $compositesQuery = $this->getCompositesQuery()
            ->orderBy(['name' => SORT_ASC])
            ->andWhere(['like', 'name', $query]);
        return $compositesQuery
            ->select(['id', 'name'])
            ->all();
    }
}
