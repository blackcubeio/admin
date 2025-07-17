<?php
/**
 * TagsAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\search;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\SearchForm;
use blackcube\admin\Module;
use blackcube\core\models\Tag;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class TagsAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class TagsAction extends Action
{
    /**
     * @var int
     */
    public $pagerSize = 10;

    /**
     * @var string view
     */
    public $view = '_list';

    /**
     * @param SearchForm $searchForm
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(SearchForm $searchForm)
    {
        $currentModuleUid = Module::getInstance()->getUniqueId();
        $elementsProvider = null;
        if (Yii::$app->request->isPost) {
            $searchForm->load(Yii::$app->request->getBodyParams(), '');
        } else {
            $searchForm->load(Yii::$app->request->getQueryParams(), '');
        }
        if ($searchForm->validate() === true) {
            if ($searchForm->tags && Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)) {
                $query = Tag::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'category', 'category.language'])
                    ->orderBy(['name' => SORT_ASC]);
                $elementsProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $query,
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
        }

        return $this->controller->renderPartial($this->view, [
            'icon' => 'outline/tag',
            'title' => Module::t('search', 'Tags'),
            'elementsProvider' => $elementsProvider,
            'additionalLinkOptions' => [
                'data-ajaxify-source' => 'tags-search'
            ],
        ]);
    }
}
