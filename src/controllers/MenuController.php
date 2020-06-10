<?php
/**
 * MenuController.php
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
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use blackcube\core\Module as CoreModule;
use blackcube\core\interfaces\BlackcubeControllerInterface;
use blackcube\core\models\Language;
use blackcube\core\models\Menu;
use blackcube\core\models\MenuItem;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\helpers\Inflector;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class MenuController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
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
            'only' => ['modal', 'item-modal', 'toggle', 'up-item', 'down-item'],
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
            'elementName' => 'menu',
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
