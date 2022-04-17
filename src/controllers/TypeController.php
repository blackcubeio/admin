<?php
/**
 * TypeController.php
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

use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\type\CreateAction;
use blackcube\admin\actions\type\DeleteAction;
use blackcube\admin\actions\type\EditAction;
use blackcube\admin\actions\type\IndexAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Type;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;

/**
 * Class TypeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class TypeController extends Controller
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
                    'roles' => [Rbac::PERMISSION_TYPE_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'actions',
                    ],
                    'roles' => [Rbac::PERMISSION_TYPE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'actions',
                    ],
                    'roles' => [Rbac::PERMISSION_TYPE_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_TYPE_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'toggle', 'actions', 'delete'],
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
            'elementClass' => Type::class
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
