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

use blackcube\core\models\Composite;
use yii\base\Action;
use yii\db\ActiveQuery;
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
class SearchAction extends Action
{

    /**
     * @var callable
     */
    public $compositesQuery;

    /**
     * @param string query
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $compositesQuery = null;
        if (is_callable($this->compositesQuery) === true) {
            $compositesQuery = call_user_func($this->compositesQuery);
        }
        if ($compositesQuery === null || (($compositesQuery instanceof ActiveQuery) === false)) {
            $compositesQuery = Composite::findOrphans();
        }

        $compositesQuery
            ->orderBy(['name' => SORT_ASC])
            ->andWhere(['like', 'name', $query]);
        return $compositesQuery
            ->select(['id', 'name'])
            ->all();
    }
}
