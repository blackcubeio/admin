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
use blackcube\admin\components\Rbac;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\models\Slug;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
        return $actions;
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $slugsQuery = Slug::find()
            ->with('seo')
            ->with('sitemap')
            ->orderBy(['path' => SORT_ASC]);
        return $this->render('index', [
            'slugsQuery' => $slugsQuery
        ]);
    }

    public function actionEdit($id)
    {
        $slug = Slug::findOne(['id' => $id]);
        if ($slug === null) {
            throw new NotFoundHttpException();
        }
        if ($slug->element === null) {
            $slug->setScenario(Slug::SCENARIO_REDIRECT);
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $slug,
        ]);

        if (Yii::$app->request->isPost) {
            $slugForm->multiLoad(Yii::$app->request->bodyParams);
            if ($slugForm->preValidate()) {
                if ($slugForm->save()) {
                    return $this->redirect(['edit', 'id' => $slug->id]);
                }
            }
        }
        return $this->render('form', [
            'slugForm' => $slugForm,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $slug = Slug::find()->with(['seo', 'sitemap'])->andWhere(['id' => $id])->one();
        if ($slug === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $slug->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $id
     * @return string|Response
     */
    public function actionToggle($id = null)
    {
        if ($id !== null) {
            $currentSlug = Slug::findOne(['id' => $id]);
            if ($currentSlug !== null) {
                $currentSlug->active = !$currentSlug->active;
                $currentSlug->save(false, ['active']);
            }
        }
        $slugsQuery = Slug::find()
            ->with('seo')
            ->with('sitemap')
            ->orderBy(['path' => SORT_ASC]);
        return $this->renderPartial('_list', [
            'slugsQuery' => $slugsQuery
        ]);
    }

}
