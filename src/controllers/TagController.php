<?php
/**
 * TagController.php
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

use blackcube\admin\actions\tag\CompositeAction;
use blackcube\admin\actions\tag\CreateAction;
use blackcube\admin\actions\tag\DeleteAction;
use blackcube\admin\actions\tag\EditAction;
use blackcube\admin\actions\tag\IndexAction;
use blackcube\admin\actions\SeoAction;
use blackcube\admin\actions\SitemapAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\SlugAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Tag;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;

/**
 * Class TagController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class TagController extends BaseElementController
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
                    'roles' => [Rbac::PERMISSION_TAG_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'blocs',
                    ],
                    'roles' => [Rbac::PERMISSION_TAG_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs', 'composites', 'slug', 'sitemap', 'seo'
                    ],
                    'roles' => [Rbac::PERMISSION_TAG_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_TAG_DELETE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'file-preview', 'file-upload', 'file-delete',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'blocs', 'composites', 'toggle', 'slug', 'sitemap', 'seo'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Tag::class,
        ];
        $actions['composites'] = [
            'class' => CompositeAction::class,
            'elementClass' => Tag::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Tag::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Tag::class,
        ];
        $actions['slug'] = [
            'class' => SlugAction::class,
            'elementClass' => Tag::class,
        ];
        $actions['sitemap'] = [
            'class' => SitemapAction::class,
            'elementClass' => Tag::class,
        ];
        $actions['seo'] = [
            'class' => SeoAction::class,
            'elementClass' => Tag::class,
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
