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
 * @package blackcube\admin\actions\slug
 */

namespace blackcube\admin\actions\slug;

use blackcube\core\models\Slug;
use yii\base\Action;
use yii\data\ActiveDataProvider;
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
 * @package blackcube\admin\actions\slug
 */
class IndexAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'index';

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $slugsQuery = Slug::find()
            ->joinWith('seo', true)
            ->joinWith('sitemap', true);
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $slugsQuery->andWhere(['or',
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $slugsProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $slugsQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'path' => SORT_ASC
                ],
                'attributes' => [
                    'path',
                    'active',
                ]
            ],
        ]);

        return $this->controller->render($this->view, [
            'slugsProvider' => $slugsProvider
        ]);
    }
}
