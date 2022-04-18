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
 * @package blackcube\admin\actions\parameter
 */

namespace blackcube\admin\actions\parameter;

use blackcube\admin\Module;
use blackcube\core\models\Parameter;
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
 * @package blackcube\admin\actions\parameter
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
        $parametersQuery = Parameter::find();
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $parametersQuery->andWhere(['or',
                ['like', 'name', $search],
                ['like', 'domain', $search],
            ]);
        }
        $parametersProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $parametersQuery,
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
                    'domain' => SORT_ASC,
                    'name' => SORT_ASC
                ],
                'attributes' => [
                    'domain',
                    'name',
                ]
            ],
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->controller->renderPartial($this->ajaxView, [
                'icon' => 'outline/puzzle',
                'title' => Module::t('parameter', 'Parameters'),
                'elementsProvider' => $parametersProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'parameters-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'elementsProvider' => $parametersProvider
        ]);
    }
}
