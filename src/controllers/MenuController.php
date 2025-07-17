<?php
/**
 * MenuController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\menu\CreateAction;
use blackcube\admin\actions\menu\CreateItemAction;
use blackcube\admin\actions\menu\DeleteAction;
use blackcube\admin\actions\menu\DeleteItemAction;
use blackcube\admin\actions\menu\DownItemAction;
use blackcube\admin\actions\menu\EditAction;
use blackcube\admin\actions\menu\EditItemAction;
use blackcube\admin\actions\menu\IndexAction;
use blackcube\admin\actions\menu\UpItemAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Menu;
use blackcube\core\models\MenuItem;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;

/**
 * Class MenuController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class MenuController extends Controller
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
                        'modal', 'item-modal', 'index',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'edit-item', 'create-item', 'up-item', 'down-item'
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete', 'delete-item',
                    ],
                    'roles' => [Rbac::PERMISSION_MENU_DELETE],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'item-modal', 'toggle', 'up-item', 'down-item', 'delete', 'delete-item'],
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
            'elementClass' => Menu::class
        ];
        $actions['item-modal'] = [
            'class' => ModalAction::class,
            'elementClass' => MenuItem::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Menu::class,
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
        $actions['create-item'] = [
            'class' => CreateItemAction::class,
        ];
        $actions['edit-item'] = [
            'class' => EditItemAction::class,
        ];
        $actions['delete-item'] = [
            'class' => DeleteItemAction::class,
        ];
        $actions['up-item'] = [
            'class' => UpItemAction::class,
        ];
        $actions['down-item'] = [
            'class' => DownItemAction::class,
        ];
        return $actions;
    }

}
