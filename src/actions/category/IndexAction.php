<?php
/**
 * IndexAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\category
 */

namespace blackcube\admin\actions\category;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Slug;
use blackcube\core\models\Type;
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
 * @package blackcube\admin\actions\category
 */
class IndexAction extends BaseElementAction
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
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(PluginsHandlerInterface $pluginsHandler)
    {
        $categoriesQuery = $this->getCategoriesQuery();
        $categoriesQuery
            ->joinWith('type', true)
            ->joinWith('slug', true)
            ->with('language')
            ->with('slug.seo')
            ->with('slug.sitemap');
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $categoriesQuery->andWhere(['or',
                ['like', Category::tableName().'.[[id]]', $search, false],
                ['like', Category::tableName().'.[[name]]', $search],
                ['like', Type::tableName().'.[[name]]', $search],
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $categoriesProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $categoriesQuery,
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
                    'active',
                    'type' => [
                        'asc' => [Type::tableName().'.[[name]]' => SORT_ASC],
                        'desc' => [Type::tableName().'.[[name]]' => SORT_DESC],
                    ],
                ]
            ],
        ]);

        if (Yii::$app->request->isAjax) {
            return $this->controller->renderPartial($this->ajaxView, [
                'icon' => 'outline/color-swatch',
                'title' => Module::t('category', 'Categories'),
                'elementsProvider' => $categoriesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'categories-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'categoriesProvider' => $categoriesProvider
        ]);
    }
}
