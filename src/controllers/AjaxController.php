<?php
/**
 * AjaxController.php
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

use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\components\PreviewManager;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * Class AjaxController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class AjaxController extends Controller
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
                        'preview'
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_PREVIEW]
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['preview'],
        ];

        return $behaviors;
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionPreview()
    {
        $previewManager = Yii::createObject([
            'class' => PreviewManager::class,
        ]);
        if ($previewManager->check() === true) {
            $previewManager->deactivate();
        } else {
            $previewManager->activate();
        }
        return Module::t('widgets', 'Preview {icon}', [
            'icon' => $previewManager->check() ? '<i class="fa fa-low-vision text-red-600"></i>':'<i class="fa fa-eye-slash"></i>'
        ]);
    }
}
