<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\models\TagManager;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use blackcube\core\actions\ResumableUploadAction;
use blackcube\core\actions\ResumablePreviewAction;
use blackcube\core\actions\ResumableDeleteAction;
use yii\base\ErrorException;
use yii\base\Event;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class TagController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Tag::class
        ];
        $actions['upload'] = [
            'class' => ResumableUploadAction::class,
        ];
        $actions['preview'] = [
            'class' => ResumablePreviewAction::class,
        ];
        $actions['delete'] = [
            'class' => ResumableDeleteAction::class,
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
            ->with('category')
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        if ($categoryId !== null) {
            $tagsQuery->andWhere(['categoryId' => $categoryId]);
        }
        return $this->render('index', [
            'tagsQuery' => $tagsQuery
        ]);
    }

    public function actionModal($id = null)
    {
        $tag = Tag::findOne(['id' => $id]);
        return $this->renderPartial('_modal', [
            'tag' => $tag,
        ]);
    }
    public function actionToggle($id = null, $categoryId = null)
    {
        if (Yii::$app->request->isAjax) {
            if ($id !== null) {
                $currentTag = Tag::findOne(['id' => $id]);
                if ($currentTag !== null) {
                    $currentTag->active = !$currentTag->active;
                    $currentTag->save(false, ['active']);
                }
            }
            $tagsQuery = Tag::find()
                ->with('category')
                ->with('slug.seo')
                ->with('slug.sitemap')
                ->orderBy(['name' => SORT_ASC]);
            if ($categoryId !== null) {
                $tagsQuery->andWhere(['categoryId' => $categoryId]);
            }
            return $this->renderPartial('_list', [
                'tagsQuery' => $tagsQuery
            ]);
        }
    }

    /**
     * @return string|Response
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $tag = new Tag();
        $slugForm = new SlugForm(['element' => $tag]);
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
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
            'typesQuery' => $typesQuery,
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
        $slugForm = new SlugForm(['element' => $tag]);
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
            'categoriesQuery' => $categoriesQuery,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
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

    /**
     * @param ElementInterface $element
     * @param Bloc[] $blocs
     * @param SlugForm $slugForm
     * @return bool
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    protected function saveElement(ElementInterface &$element, &$blocs, SlugForm &$slugForm)
    {
        $saveStatus = false;
        // $slugForm = new SlugForm(['element' => $element]);
        // $blocs = $element->getBlocs()->all();
        if (Yii::$app->request->isPost) {
            Model::loadMultiple($blocs, Yii::$app->request->bodyParams);
            $element->load(Yii::$app->request->bodyParams);
            $slugForm->multiLoad(Yii::$app->request->bodyParams);

            if ($element->validate() && $slugForm->preValidate() && Model::validateMultiple($blocs)) {
                $transaction = Module::getInstance()->db->beginTransaction();
                $slugFormStatus = $slugForm->save();
                $elementStatus = $element->save();
                $blocStatus = true;
                foreach($blocs as $bloc) {
                    $bloc->active = true;
                    $blocStatus = $blocStatus && $bloc->save();
                }
                if ($slugFormStatus && $elementStatus && $blocStatus) {
                    if ($slugForm->hasSlug) {
                        $element->attachSlug($slugForm->getSlug());
                    } else {
                        $element->detachSlug();
                    }
                    $transaction->commit();
                    $saveStatus = true;
                } else {
                    $transaction->rollBack();
                    throw new ErrorException();
                }
            }
        }
        return $saveStatus;
        // return [$element, $slugForm, $blocs];
    }

}
