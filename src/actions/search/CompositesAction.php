<?php
/**
 * CompositesAction.php
 *
 * PHP version 8.0+
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
use blackcube\core\models\Composite;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CompositesAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\search
 */
class CompositesAction extends Action
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

            if ($searchForm->composites && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)) {
                $query = Composite::find()
                    ->andWhere(['like', 'name', $searchForm->search])
                    ->with(['slug', 'slug.seo', 'slug.sitemap', 'type', 'language'])
                    ->orderBy(['name' => SORT_ASC]);
                $elementsProvider = Yii::createObject([
                    'class' => ActiveDataProvider::class,
                    'query' => $query,
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
        }

        return $this->controller->renderPartial($this->view, [
            'icon' => 'outline/document-text',
            'title' => Module::t('search', 'Composites'),
            'elementsProvider' => $elementsProvider,
            'additionalLinkOptions' => [
                'data-ajaxify-source' => 'composites-search'
            ],
        ]);
    }
}
