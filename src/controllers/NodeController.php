<?php
/**
 * NodeController.php
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

use blackcube\admin\actions\node\CompositeAction;
use blackcube\admin\actions\node\CreateAction;
use blackcube\admin\actions\node\DeleteAction;
use blackcube\admin\actions\node\EditAction;
use blackcube\admin\actions\node\IndexAction;
use blackcube\admin\actions\SeoAction;
use blackcube\admin\actions\SitemapAction;
use blackcube\admin\actions\TagAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\SlugAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use Yii;

/**
 * Class NodeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class NodeController extends BaseElementController
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
                        'modal', 'index',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'blocs',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs', 'composites', 'slug', 'sitemap', 'seo', 'tag'
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_DELETE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'file-preview', 'file-upload', 'file-delete',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'blocs', 'composites', 'toggle', 'slug', 'sitemap', 'seo', 'tag'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Node::class,
        ];
        $actions['composites'] = [
            'class' => CompositeAction::class,
            'elementClass' => Node::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Node::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Node::class,
        ];
        $actions['slug'] = [
            'class' => SlugAction::class,
            'elementClass' => Node::class,
        ];
        $actions['sitemap'] = [
            'class' => SitemapAction::class,
            'elementClass' => Node::class,
        ];
        $actions['seo'] = [
            'class' => SeoAction::class,
            'elementClass' => Node::class,
        ];
        $actions['tag'] = [
            'class' => TagAction::class,
            'elementClass' => Node::class,
        ];
        $actions['index'] = [
            'class' => IndexAction::class,
        ];
        $actions['create'] = [
            'class' => CreateAction::class,
        ];
        $actions['edit'] = [
            'class' => EditAction::class,
        ];
        $actions['delete'] = [
            'class' => DeleteAction::class,
        ];
        return $actions;
    }

}
