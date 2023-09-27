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
 * @package blackcube\admin\actions\tag
 */

namespace blackcube\admin\actions\tag;

use blackcube\admin\Module;
use blackcube\admin\actions\BaseElementAction;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
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
 * @package blackcube\admin\actions\tag
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
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(PluginsHandlerInterface $pluginsHandler)
    {
        $tagsQuery = $this->getTagsQuery();
        $tagsQuery
            ->joinWith('type', true)
            ->joinWith('slug', true)
            ->joinWith('category', true)
            ->joinWith('category.language', true)
            // ->with('category.language')
            ->with('slug.seo')
            ->with('slug.sitemap');
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $tagsQuery->andWhere(['or',
                ['like', Tag::tableName().'.[[id]]', $search, false],
                ['like', Tag::tableName().'.[[name]]', $search],
                ['like', Category::tableName().'.[[name]]', $search],
                ['like', Type::tableName().'.[[name]]', $search],
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $tagsProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $tagsQuery,
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
                'title' => Module::t('tag', 'Tags'),
                'elementsProvider' => $tagsProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'tags-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'tagsProvider' => $tagsProvider
        ]);
    }
}
