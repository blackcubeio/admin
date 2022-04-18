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
 * @package blackcube\admin\actions\search
 */

namespace blackcube\admin\actions\search;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\SearchForm;
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
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
 * @package blackcube\admin\actions\search
 */
class IndexAction extends Action
{
    /**
     * @var int
     */
    public $pagerSize = 10;
    /**
     * @var string view
     */
    public $view = 'index';

    /**
     * @param SearchForm $searchForm
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(SearchForm $searchForm)
    {
        $currentModuleUid = Module::getInstance()->getUniqueId();
        $nodesProvider = null;
        $compositesProvider = null;
        $categoriesProvider = null;
        $tagsProvider = null;
        $slugsProvider = null;
        if (Yii::$app->request->isPost) {
            $searchForm->load(Yii::$app->request->getBodyParams(), '');
        } else {
            $searchForm->load(Yii::$app->request->getQueryParams(), '');
        }
        if ($searchForm->validate() === true) {
            if ($searchForm->nodes && Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)) {
                $nodesQuery = Node::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                    ->orderBy(['name' => SORT_ASC]);
                $nodesProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $nodesQuery,
                    'pagination' => [
                        'pageSize' => $this->pagerSize,
                        'pageParam' => 'nodesPage',
                        'params' => $searchForm->getAttributes() + [
                            'nodesPage' => Yii::$app->request->getQueryParam('nodesPage', 0)
                        ],
                        'route' => '/'. $currentModuleUid .'/search/nodes',
                    ]
                ]);
            }
            if ($searchForm->composites && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)) {
                $compositesQuery = Composite::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                    ->orderBy(['name' => SORT_ASC]);
                $compositesProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $compositesQuery,
                    'pagination' => [
                        'pageSize' => $this->pagerSize,
                        'pageParam' => 'compositesPage',
                        'params' => $searchForm->getAttributes() + [
                            'compositesPage' => Yii::$app->request->getQueryParam('compositesPage', 0)
                        ],
                        'route' => '/'. $currentModuleUid .'/search/composites',
                    ]
                ]);
            }
            if ($searchForm->categories && Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)) {
                $categoriesQuery = Category::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                    ->orderBy(['name' => SORT_ASC]);
                $categoriesProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $categoriesQuery,
                    'pagination' => [
                        'pageSize' => $this->pagerSize,
                        'pageParam' => 'categoriesPage',
                        'params' => $searchForm->getAttributes() + [
                                'categoriesPage' => Yii::$app->request->getQueryParam('categoriesPage', 0)
                            ],
                        'route' => '/'. $currentModuleUid .'/search/categories',
                    ],
                ]);
            }
            if ($searchForm->tags && Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)) {
                $tagsQuery = Tag::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'category', 'category.language'])
                    ->orderBy(['name' => SORT_ASC]);
                $tagsProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $tagsQuery,
                    'pagination' => [
                        'pageSize' => $this->pagerSize,
                        'pageParam' => 'tagsPage',
                        'params' => $searchForm->getAttributes() + [
                                'tagsPage' => Yii::$app->request->getQueryParam('tagsPage', 0)
                            ],
                        'route' => '/'. $currentModuleUid .'/search/tags',
                    ]
                ]);
            }
            if ($searchForm->slugs && Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)) {
                $slugsQuery = Slug::find()
                    ->andWhere(['like', 'path', $searchForm->search])
                    ->andWhere(['is not', 'targetUrl', null])
                    ->with(['seo', 'sitemap'])
                    ->orderBy(['path' => SORT_ASC]);
                $slugsProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $slugsQuery,
                    'pagination' => [
                        'pageSize' => $this->pagerSize,
                        'pageParam' => 'slugsPage',
                        'params' => $searchForm->getAttributes() + [
                                'slugsPage' => Yii::$app->request->getQueryParam('slugsPage', 0)
                            ],
                        'route' => '/'. $currentModuleUid .'/search/slugs',
                    ],
                ]);
            }
        }
            /*/
        } else {
            $searchForm->validate();
            $searchForm->clearErrors();
        }
            /**/
        return $this->controller->render($this->view, [
            'searchForm' => $searchForm,
            'nodesProvider' => $nodesProvider,
            'compositesProvider' => $compositesProvider,
            'categoriesProvider' => $categoriesProvider,
            'tagsProvider' => $tagsProvider,
            'slugsProvider' => $slugsProvider,
            'currentModuleUid' => $currentModuleUid,
        ]);
    }
}
