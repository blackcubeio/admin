<?php
/**
 * SlugController.php
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
use blackcube\admin\actions\slug\CreateAction;
use blackcube\admin\actions\slug\DeleteAction;
use blackcube\admin\actions\slug\EditAction;
use blackcube\admin\actions\slug\IndexAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Slug;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;

/**
 * Class SlugController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class SlugController extends BaseElementController
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
                    'roles' => [Rbac::PERMISSION_SLUG_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'toggle', 'edit', 'create',
                    ],
                    'roles' => [Rbac::PERMISSION_SLUG_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_SLUG_DELETE],
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
            'elementClass' => Slug::class
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
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Slug::class,
        ];
        return $actions;
    }


}
