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

use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Type;
use yii\base\Action;
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
     * @param string query
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($query)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $compositeQuery = Composite::findOrphans()
            ->orderBy(['name' => SORT_ASC])
            ->andWhere(['like', 'name', $query]);
        return $compositeQuery
            ->select(['id', 'name'])
            ->all();
    }
}
