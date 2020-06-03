<?php
/**
 * CategoryController.php
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

use blackcube\admin\actions\category\CreateAction;
use blackcube\admin\actions\category\DeleteAction;
use blackcube\admin\actions\category\EditAction;
use blackcube\admin\actions\category\IndexAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Language;
use blackcube\core\models\Slug;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CategoryController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class CategoryController extends BaseElementController
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
                    'roles' => [Rbac::PERMISSION_CATEGORY_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'blocs',
                    ],
                    'roles' => [Rbac::PERMISSION_CATEGORY_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs',
                    ],
                    'roles' => [Rbac::PERMISSION_CATEGORY_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_CATEGORY_DELETE],
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
            'only' => ['modal', 'blocs', 'toggle'],
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
            'elementClass' => Category::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Category::class,
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Category::class,
            'elementName' => 'category',
        ];
        $actions['index'] = [
            'class' => IndexAction::class
        ];
        $actions['create'] = [
            'class' => CreateAction::class
        ];
        $actions['edit'] = [
            'class' => EditAction::class
        ];
        $actions['delete'] = [
            'class' => DeleteAction::class
        ];
        return $actions;
    }

}
