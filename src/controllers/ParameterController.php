<?php
/**
 * ParameterController.php
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
use blackcube\admin\actions\parameter\CreateAction;
use blackcube\admin\actions\parameter\DeleteAction;
use blackcube\admin\actions\parameter\EditAction;
use blackcube\admin\actions\parameter\IndexAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Parameter;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;

/**
 * Class ParameterController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class ParameterController extends Controller
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
                    'roles' => [Rbac::PERMISSION_PARAMETER_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_PARAMETER_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'toggle', 'delete'],
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
            'elementClass' => Parameter::class
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
