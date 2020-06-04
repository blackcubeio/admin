<?php
/**
 * BlocTypeController.php
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

use blackcube\admin\actions\bloctype\CreateAction;
use blackcube\admin\actions\bloctype\DeleteAction;
use blackcube\admin\actions\bloctype\EditAction;
use blackcube\admin\actions\bloctype\IndexAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\BlocType;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use Yii;

/**
 * Class BlocTypeController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class BlocTypeController extends Controller
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
                    'roles' => [Rbac::PERMISSION_BLOCTYPE_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit',
                    ],
                    'roles' => [Rbac::PERMISSION_BLOCTYPE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle',
                    ],
                    'roles' => [Rbac::PERMISSION_BLOCTYPE_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_BLOCTYPE_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal'],
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
            'elementClass' => BlocType::class
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
