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
 * @package blackcube\admin\actions\search
 */

namespace blackcube\admin\actions\search;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\SearchForm;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\base\Action;
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
 * @package blackcube\admin\actions\search
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
        $searchForm = Yii::createObject(SearchForm::class);
        $nodesQuery = null;
        $compositesQuery = null;
        $categoriesQuery = null;
        $tagsQuery = null;
        $slugsQuery = null;
        if (Yii::$app->request->isPost) {
            $searchForm->load(Yii::$app->request->bodyParams);
            if ($searchForm->validate() === true) {
                if ($searchForm->nodes && Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)) {
                    $nodesQuery = Node::find()
                        ->andWhere(['like', 'name', $searchForm->search])
                        ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                        ->orderBy(['name' => SORT_ASC]);
                }
                if ($searchForm->composites && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)) {
                    $compositesQuery = Composite::find()
                        ->andWhere(['like', 'name', $searchForm->search])
                        ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                        ->orderBy(['name' => SORT_ASC]);
                }
                if ($searchForm->categories && Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)) {
                    $categoriesQuery = Category::find()
                        ->andWhere(['like', 'name', $searchForm->search])
                        ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                        ->orderBy(['name' => SORT_ASC]);
                }
                if ($searchForm->tags && Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)) {
                    $tagsQuery = Tag::find()
                        ->andWhere(['like', 'name', $searchForm->search])
                        ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'category', 'category.language'])
                        ->orderBy(['name' => SORT_ASC]);
                }
                if ($searchForm->slugs && Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)) {
                    $slugsQuery = Slug::find()
                        ->andWhere(['like', 'path', $searchForm->search])
                        ->andWhere(['is not', 'targetUrl', null])
                        ->with(['seo', 'sitemap'])
                        ->orderBy(['path' => SORT_ASC]);
                }
            }
        } else {
            $searchForm->validate();
            $searchForm->clearErrors();
        }
        return $this->controller->render($this->view, [
            'searchForm' => $searchForm,
            'nodesQuery' => $nodesQuery,
            'compositesQuery' => $compositesQuery,
            'categoriesQuery' => $categoriesQuery,
            'tagsQuery' => $tagsQuery,
            'slugsQuery' => $slugsQuery,
        ]);
    }
}
