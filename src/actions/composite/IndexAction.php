<?php
/**
 * IndexAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\Module;
use blackcube\admin\actions\BaseElementAction;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Composite;
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
 * @package blackcube\admin\actions\composite
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
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $compositesQuery = $this->getCompositesQuery();
        $compositesQuery
            ->joinWith('type', true)
            ->joinWith('slug', true)
            ->with('language')
            ->with('slug.seo')
            ->with('slug.sitemap');
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $compositesQuery->andWhere(['or',
                ['like', Composite::tableName().'.[[id]]', $search, false],
                ['like', Composite::tableName().'.[[name]]', $search],
                ['like', Type::tableName().'.[[name]]', $search],
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $compositesProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $compositesQuery,
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
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */

        if (Yii::$app->request->isAjax) {
            return $this->controller->renderPartial('_list', [
                'icon' => 'outline/document-text',
                'title' => Module::t('composite', 'Composites'),
                'elementsProvider' => $compositesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'composites-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'compositesProvider' => $compositesProvider
        ]);
    }
}
