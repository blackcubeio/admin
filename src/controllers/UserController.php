<?php
/**
 * UserController.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\user\CreateAction;
use blackcube\admin\actions\user\DeleteAction;
use blackcube\admin\actions\user\EditAction;
use blackcube\admin\actions\user\IndexAction;
use blackcube\admin\actions\user\RbacAction;
use blackcube\admin\actions\user\AccountAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\models\Administrator;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use Yii;

/**
 * Class UserController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class UserController extends Controller
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
                    'roles' => [Rbac::PERMISSION_USER_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'rbac',
                    ],
                    'roles' => [Rbac::PERMISSION_USER_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'rbac', 'toggle',
                    ],
                    'roles' => [Rbac::PERMISSION_USER_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_USER_DELETE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'account',
                    ],
                    'roles' => ['@'],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'rbac', 'toggle', 'delete'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Administrator::class
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
        $actions['account'] = [
            'class' => AccountAction::class,
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Administrator::class
        ];
        $actions['rbac'] = [
            'class' => RbacAction::class,
        ];
        return $actions;
    }


}
