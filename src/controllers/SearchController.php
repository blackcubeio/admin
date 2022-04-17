<?php
/**
 * SearchController.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\search\CategoriesAction;
use blackcube\admin\actions\search\CompositesAction;
use blackcube\admin\actions\search\IndexAction;
use blackcube\admin\actions\search\NodesAction;
use blackcube\admin\actions\search\SlugsAction;
use blackcube\admin\actions\search\TagsAction;
use blackcube\admin\components\Rbac;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;

/**
 * Class SearchController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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
                        'index',
                        'composites',
                        'nodes',
                        'categories',
                        'tags',
                        'slugs',
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_SEARCH],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => [
                'composites',
                'nodes',
                'categories',
                'tags',
                'slugs',
            ],
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
        $actions['nodes'] = [
            'class' => NodesAction::class,
        ];
        $actions['composites'] = [
            'class' => CompositesAction::class,
        ];
        $actions['categories'] = [
            'class' => CategoriesAction::class,
        ];
        $actions['tags'] = [
            'class' => TagsAction::class,
        ];
        $actions['slugs'] = [
            'class' => SlugsAction::class,
        ];
        return $actions;
    }

}
