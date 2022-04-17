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
 * @package blackcube\admin\actions\menu
 */

namespace blackcube\admin\actions\menu;

use blackcube\admin\Module;
use blackcube\core\models\Menu;
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
 * @package blackcube\admin\actions\menu
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
        $menusQuery = Menu::find();
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $menusQuery->andWhere(['or',
                ['like', 'id', $search, false],
                ['like', 'name', $search],
            ]);
        }
        $menusProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $menusQuery,
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
            return $this->controller->renderPartial('_list', [
                'icon' => 'outline/view-list',
                'title' => Module::t('menu', 'Menus'),
                'elementsProvider' => $menusProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'menus-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'elementsProvider' => $menusProvider
        ]);
    }
}
