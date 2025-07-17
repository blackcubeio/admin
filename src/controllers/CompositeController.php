<?php
/**
 * CompositeController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\controllers;

use blackcube\admin\actions\composite\CreateAction;
use blackcube\admin\actions\composite\DeleteAction;
use blackcube\admin\actions\composite\EditAction;
use blackcube\admin\actions\composite\IndexAction;
use blackcube\admin\actions\ExportAction;
use blackcube\admin\actions\SeoAction;
use blackcube\admin\actions\SitemapAction;
use blackcube\admin\actions\TagAction;
use blackcube\admin\actions\ToggleAction;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\actions\SlugAction;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Composite;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;

/**
 * Class CompositeController
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class CompositeController extends BaseElementController
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
                    'roles' => [Rbac::PERMISSION_COMPOSITE_VIEW],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'create', 'edit', 'blocs',
                    ],
                    'roles' => [Rbac::PERMISSION_COMPOSITE_CREATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'edit', 'toggle', 'blocs', 'slug', 'sitemap', 'seo', 'tag'
                    ],
                    'roles' => [Rbac::PERMISSION_COMPOSITE_UPDATE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'delete',
                    ],
                    'roles' => [Rbac::PERMISSION_COMPOSITE_DELETE],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'file-preview', 'file-upload', 'file-delete',
                    ],
                    'roles' => ['@'],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'export',
                    ],
                    'roles' => [Rbac::PERMISSION_COMPOSITE_EXPORT],
                ],
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'blocs', 'toggle', 'slug', 'sitemap', 'seo', 'tag'],
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
            'elementClass' => Composite::class,
        ];
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Composite::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['slug'] = [
            'class' => SlugAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['sitemap'] = [
            'class' => SitemapAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['seo'] = [
            'class' => SeoAction::class,
            'elementClass' => Composite::class,
        ];
        $actions['tag'] = [
            'class' => TagAction::class,
            'elementClass' => Composite::class,
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
        $actions['export'] = [
            'class' => ExportAction::class,
            'elementClass' => Composite::class,
        ];
        return $actions;
    }

}
