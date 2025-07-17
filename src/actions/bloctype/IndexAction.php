<?php
/**
 * IndexAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\bloctype;

use blackcube\admin\Module;
use blackcube\core\models\BlocType;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
     * @var string view
     */
    public $ajaxView = '_list';

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
        if (Yii::$app->request->isAjax) {
            return $this->controller->renderPartial($this->ajaxView, [
                'icon' => 'outline/cube',
                'title' => Module::t('bloc-type', 'Bloc types'),
                'elementsProvider' => $blocTypesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'bloc-types-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'elementsProvider' => $blocTypesProvider
        ]);
    }
}
