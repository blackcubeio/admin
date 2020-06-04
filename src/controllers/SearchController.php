<?php
/**
 * SearchController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\search\IndexAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\models\SearchForm;
use blackcube\admin\Module;
use blackcube\core\components\PreviewManager;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * Class SearchController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class SearchController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'index'
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_SEARCH],
                ],
            ]
        ];

        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['index'] = [
            'class' => IndexAction::class,
        ];
        return $actions;
    }

}
