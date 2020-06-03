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

use blackcube\admin\actions\node\CompositesAction;
use blackcube\admin\actions\node\CreateAction;
use blackcube\admin\actions\node\DeleteAction;
use blackcube\admin\actions\node\EditAction;
use blackcube\admin\actions\node\IndexAction;
use blackcube\admin\actions\node\SearchAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Language;
use blackcube\core\models\Slug;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
                        'create', 'edit', 'blocs', 'composites', 'search',
                    ],
                    'roles' => [Rbac::PERMISSION_NODE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs', 'composites', 'search',
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
            'only' => ['modal', 'blocs', 'toggle', 'composites', 'search'],
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
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Node::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Node::class,
            'elementName' => 'node',
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
        $actions['composites'] = [
            'class' => CompositesAction::class,
        ];
        $actions['search'] = [
            'class' => SearchAction::class,
        ];
        return $actions;
    }

}
