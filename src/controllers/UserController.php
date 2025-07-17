<?php
/**
 * UserController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
                        'delete-passkey',
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
        $actions['delete-passkey'] = [
            'class' => \blackcube\admin\actions\passkey\DeleteAction::class,
        ];
        return $actions;
    }


}
