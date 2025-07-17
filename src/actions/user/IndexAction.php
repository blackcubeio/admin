<?php
/**
 * IndexAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\models\Administrator;
use blackcube\admin\Module;
use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
        $usersQuery = Administrator::find()
            ->orderBy(['email' => SORT_ASC]);
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $usersQuery->andWhere(['or',
                ['like', 'id', $search, false],
                ['like', 'email', $search],
                ['like', 'firstname', $search],
                ['like', 'lastname', $search],
            ]);
        }
        $usersProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $usersQuery,
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
                    'lastname' => SORT_ASC
                ],
                'attributes' => [
                    'email',
                    'firstname',
                    'lastname',
                    'email',
                    'active',
                ]
            ],
        ]);
        if (Yii::$app->request->isAjax) {
            return $this->controller->renderPartial($this->ajaxView, [
                'icon' => 'outline/users',
                'title' => Module::t('user', 'Users'),
                'elementsProvider' => $usersProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'users-search'
                ]
            ]);
        }
        return $this->controller->render($this->view, [
            'elementsProvider' => $usersProvider
        ]);
    }
}
