<?php
/**
 * DefaultController.php
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
use blackcube\core\components\PreviewManager;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;
use yii\web\Response;

/**
 * Class DefaultController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class DefaultController extends Controller
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
                        'index'
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_DASHBOARD],
                ],
                [
                    'allow' => true,
                    'actions' => [
                        'preview'
                    ],
                    'roles' => [Rbac::PERMISSION_SITE_PREVIEW]
                ]
            ]
        ];
        return $behaviors;
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $countComposites = [
            'global' => Composite::find()->count(),
            'active' => Composite::find()->active()->count(),
            'activeWithSlug' => Composite::find()->active()->innerJoinWith('slug')->andWhere([Slug::tableName().'.active' => true])->count(),
        ];
        $countNodes = [
            'global' => Node::find()->count(),
            'active' => Node::find()->active()->count(),
            'activeWithSlug' => Node::find()->active()->innerJoinWith('slug')->andWhere([Slug::tableName().'.active' => true])->count(),
        ];
        $countCategories = [
            'global' => Category::find()->count(),
            'active' => Category::find()->active()->count(),
            'activeWithSlug' => Category::find()->active()->innerJoinWith('slug')->andWhere([Slug::tableName().'.active' => true])->count(),
        ];
        $countTags = [
            'global' => Tag::find()->count(),
            'active' => Tag::find()->active()->count(),
            'activeWithSlug' => Tag::find()->active()->innerJoinWith('slug')->andWhere([Slug::tableName().'.active' => true])->count(),
        ];
        return $this->render('index', [
            'countComposites' => $countComposites,
            'countNodes' => $countNodes,
            'countCategories' => $countCategories,
            'countTags' => $countTags,
        ]);
    }

    public function actionPreview()
    {
        $previewManager = Yii::createObject([
            'class' => PreviewManager::class,
        ]);
        if ($previewManager->check() === true) {
            $previewManager->deactivate();
        } else {
            $previewManager->activate();
            $previewManager->setSimulateDate('2020-04-25');
        }
        return 'Preview Status = '.$previewManager->check();
    }
    /**
     * @return string|Response
     * @todo: remove
     */
    public function actionTest()
    {
        return $this->render('test', []);
    }
}
