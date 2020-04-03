<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\models\TagManager;
use blackcube\admin\actions\BlocAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Bloc;
use blackcube\core\models\Category;
use blackcube\core\models\Language;
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

class CategoryController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['blocs'] = [
            'class' => BlocAction::class,
            'elementClass' => Category::class
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
     * @return string
     */
    public function actionIndex()
    {
        $categoriesQuery = Category::find()
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        return $this->render('index', [
            'categoriesQuery' => $categoriesQuery
        ]);
    }

    public function actionModal($id = null)
    {
        $category = Category::findOne(['id' => $id]);
        return $this->renderPartial('_modal', [
            'category' => $category,
        ]);
    }
    public function actionToggle($id = null, $categoryId = null)
    {
        if (Yii::$app->request->isAjax) {
            if ($id !== null) {
                $currentCategory = Category::findOne(['id' => $id]);
                if ($currentCategory !== null) {
                    $currentCategory->active = !$currentCategory->active;
                    $currentCategory->save(false, ['active']);
                }
            }
            $categoriesQuery = Category::find()
                ->with('slug.seo')
                ->with('slug.sitemap')
                ->orderBy(['name' => SORT_ASC]);
            return $this->renderPartial('_list', [
                'categoriesQuery' => $categoriesQuery
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
        $category = new Category();
        $slugForm = new SlugForm(['element' => $category]);
        $blocs = $category->getBlocs()->all();
        $result = $this->saveElement($category, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['category/edit', 'id' => $category->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'category' => $category,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'languagesQuery' => $languagesQuery,
            'blocs' => $blocs,
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
        $category = Category::findOne(['id' => $id]);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = new SlugForm(['element' => $category]);
        $blocs = $category->getBlocs()->all();
        $result = $this->saveElement($category, $blocs, $slugForm);
        if ($result === true) {
            return $this->redirect(['category/edit', 'id' => $category->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'category' => $category,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'languagesQuery' => $languagesQuery,
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
        $category = Category::findOne(['id' => $id]);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $category->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $category->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $category->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->redirect(['category/index']);
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
