<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\actions\ModalAction;
use blackcube\admin\Module;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

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
                        'modal', 'blocs', 'index', 'toggle', 'create', 'edit', 'delete', 'preview', 'upload', 'delete',
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
        return $actions;
    }

    /**
     * @param string|null $id
     * @param string|null $categoryId
     * @return string
     */
    public function actionIndex($categoryId = null)
    {
        $tagsQuery = Tag::find()
            ->innerJoinWith('category', true)
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy([
                Category::tableName().'.name' => SORT_ASC,
                'name' => SORT_ASC
            ]);

        if ($categoryId !== null) {
            $tagsQuery->andWhere(['categoryId' => $categoryId]);
        }
        return $this->render('index', [
            'tagsQuery' => $tagsQuery
        ]);
    }

    public function actionToggle($id = null, $categoryId = null)
    {
        if ($id !== null) {
            $currentTag = Tag::findOne(['id' => $id]);
            if ($currentTag !== null) {
                $currentTag->active = !$currentTag->active;
                $currentTag->save(false, ['active']);
            }
        }
        $tagsQuery = Tag::find()
            ->innerJoinWith('category', true)
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy([
                Category::tableName().'.name' => SORT_ASC,
                'name' => SORT_ASC
            ]);
        if ($categoryId !== null) {
            $tagsQuery->andWhere(['categoryId' => $categoryId]);
        }
        return $this->renderPartial('_list', [
            'tagsQuery' => $tagsQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws ErrorException
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
