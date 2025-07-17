<?php
/**
 * PluginController.php
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
use blackcube\admin\actions\plugin\EditAction;
use blackcube\admin\actions\plugin\IndexAction;
use blackcube\admin\actions\plugin\ToggleAction;
use blackcube\admin\actions\plugin\ToggleRegisterAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Plugin;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;

/**
 * Class PluginController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class PluginController extends Controller
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
                    'roles' => [Rbac::PERMISSION_PLUGIN_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'toggle-register',
                    ],
                    'roles' => [Rbac::PERMISSION_PLUGIN_UPDATE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'actions', 'toggle', 'toggle-register'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['toggle'] = [
            'class' => ToggleAction::class
        ];
        $actions['toggle-register'] = [
            'class' => ToggleRegisterAction::class
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Plugin::class
        ];
        $actions['index'] = [
            'class' => IndexAction::class,
        ];
        $actions['edit'] = [
            'class' => EditAction::class,
        ];
        return $actions;
    }
}
