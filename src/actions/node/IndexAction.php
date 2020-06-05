<?php
/**
 * IndexAction.php
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

use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class IndexAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'index';

    /**
     * @var callable
     */
    public $nodesQuery;

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $nodesQuery = null;
        if (is_callable($this->nodesQuery) === true) {
            $nodesQuery = call_user_func($this->nodesQuery);
        }
        if ($nodesQuery === null || (($nodesQuery instanceof ActiveQuery) === false)) {
            $nodesQuery = Node::find();
        }

        $nodesQuery
            ->joinWith('type', true)
            ->joinWith('slug', true)
            ->with('slug.seo')
            ->with('slug.sitemap');
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $nodesQuery->andWhere(['or',
                ['like', Node::tableName().'.[[name]]', $search],
                ['like', Type::tableName().'.[[name]]', $search],
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $nodesProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $nodesQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'tree' => SORT_ASC
                ],
                'attributes' => [
                    'name',
                    'active',
                    'type' => [
                        'asc' => [Type::tableName().'.[[name]]' => SORT_ASC],
                        'desc' => [Type::tableName().'.[[name]]' => SORT_DESC],
                    ],
                    'tree' => [
                        'asc' => ['left' => SORT_ASC],
                        'desc' => ['left' => SORT_DESC],
                    ]
                ]
            ],
        ]);

        return $this->controller->render($this->view, [
            'nodesProvider' => $nodesProvider
        ]);
    }
}
