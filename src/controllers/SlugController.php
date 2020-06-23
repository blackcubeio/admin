<?php
/**
 * SlugController.php
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

use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\slug\DeleteAction;
use blackcube\admin\actions\slug\EditAction;
use blackcube\admin\actions\slug\IndexAction;
use blackcube\admin\actions\slug\ToggleAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Slug;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use Yii;

/**
 * Class SlugController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
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
                        'toggle', 'edit',
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
            'only' => ['modal', 'toggle'],
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
        $actions['edit'] = [
            'class' => EditAction::class,
        ];
        $actions['delete'] = [
            'class' => DeleteAction::class,
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
        ];
        return $actions;
    }


}
