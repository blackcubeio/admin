<?php
/**
 * IndexAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\bloctype
 */

namespace blackcube\admin\actions\bloctype;

use blackcube\core\models\BlocType;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\bloctype
 */
class IndexAction extends Action
{
    /**
     * @var int
     */
    public $pagerSize = 20;

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
        $blocTypesQuery = BlocType::find()
            ->orderBy(['name' => SORT_ASC]);
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $blocTypesQuery->andWhere(['or',
                ['like', 'id', $search, false],
                ['like', 'name', $search],
            ]);
        }
        $blocTypesProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $blocTypesQuery,
            'pagination' => [
                'pageSize' => $this->pagerSize,
                'pageParam' => 'page',
                'params' => [
                    'search' => $search,
                    'page' => Yii::$app->request->getQueryParam('page', 0)
                ],
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC
                ],
                'attributes' => [
                    'name',
                ]
            ],
        ]);
        return $this->controller->render($this->view, [
            'elementsProvider' => $blocTypesProvider
        ]);
    }
}
