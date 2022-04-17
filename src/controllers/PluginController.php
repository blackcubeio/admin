<?php
/**
 * PluginController.php
 *
 * PHP version 7.2+
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
use blackcube\admin\actions\plugin\IndexAction;
use blackcube\admin\actions\plugin\ToggleAction;
use blackcube\admin\actions\plugin\ToggleRegisterAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Plugin;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use Yii;

/**
 * Class PluginController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
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
        return $actions;
    }
}
