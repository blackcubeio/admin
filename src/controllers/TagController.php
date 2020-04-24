<?php
/**
 * TagController.php
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

use blackcube\admin\actions\ToggleAction;
use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\components\Rbac;
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class TagController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
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
                        'edit', 'toggle', 'blocs',
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
            'only' => ['modal', 'blocs', 'toggle'],
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
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Tag::class
        ];
        $actions['toggle'] = [
            'class' => ToggleAction::class,
            'elementClass' => Tag::class,
            'elementName' => 'tag',
        ];
        return $actions;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $tagsQuery = Tag::find()
            ->innerJoinWith('category', true)
            ->joinWith('type', true)
            ->joinWith('slug', true)
            ->with('slug.seo')
            ->with('slug.sitemap');
        $search = Yii::$app->request->getQueryParam('search', null);
        if ($search !== null) {
            $tagsQuery->andWhere(['or',
                ['like', Tag::tableName().'.[[name]]', $search],
                ['like', Category::tableName().'.[[name]]', $search],
                ['like', Type::tableName().'.[[name]]', $search],
                ['like', Slug::tableName().'.[[path]]', $search],
            ]);
        }
        $tagsProvider = Yii::createObject([
            'class' => ActiveDataProvider::class,
            'query' => $tagsQuery,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC
                ],
                'attributes' => [
                    'name',
                    'active',
                    'type' => [
                        'asc' => [Type::tableName().'.[[name]]' => SORT_ASC],
                        'desc' => [Type::tableName().'.[[name]]' => SORT_DESC],
                    ],
                ]
            ],
        ]);
        return $this->render('index', [
            'tagsProvider' => $tagsProvider
        ]);
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $tag = Yii::createObject(Tag::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $tag,
        ]);
        $blocs = $tag->getBlocs()->all();
        $result = $this->saveElement($tag, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['tag/edit', 'id' => $tag->id]);
        }
        $categoriesQuery = Category::find()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'tag' => $tag,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws ErrorException
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionEdit($id)
    {
        $tag = Tag::findOne(['id' => $id]);
        if ($tag === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $tag
        ]);
        $blocs = $tag->getBlocs()->all();
        $result = $this->saveElement($tag, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['tag/edit', 'id' => $tag->id]);
        }
        $categoriesQuery = Category::find()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'tag' => $tag,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
        ]);
    }

    /**
     * @param integer $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $tag = Tag::findOne(['id' => $id]);
        if ($tag === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $tag->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $tag->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $tag->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->redirect(['tag/index']);
    }

}
