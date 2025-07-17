<?php
/**
 * SlugsAction.php
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
use blackcube\core\models\Slug;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class SlugsAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class SlugsAction extends Action
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
            if ($searchForm->slugs && Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)) {
                $query = Slug::find()
                    ->andWhere(['like', 'path', $searchForm->search])
                    ->andWhere(['is not', 'targetUrl', null])
                    ->with(['seo', 'sitemap'])
                    ->orderBy(['path' => SORT_ASC]);
                $elementsProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $query,
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

        return $this->controller->renderPartial($this->view, [
            'icon' => 'outline/link',
            'title' => Module::t('search', 'Slugs'),
            'elementsProvider' => $elementsProvider,
            'additionalLinkOptions' => [
                'data-ajaxify-source' => 'slugs-search'
            ],
        ]);
    }
}
