<?php

namespace blackcube\admin\controllers;

use blackcube\admin\models\SlugForm;
use blackcube\admin\models\TagManager;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use blackcube\core\models\Type;
use yii\base\ErrorException;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

class TagController extends Controller
{

    /**
     * @param string|null $id
     * @param string|null $categoryId
     * @return string
     */
    public function actionIndex($id = null, $categoryId = null)
    {
        $tagsQuery = Tag::find()
            ->with('category')
            ->with('slug.seo')
            ->with('slug.sitemap')
            ->orderBy(['name' => SORT_ASC]);
        if ($id !== null) {
            $tagsQuery->andWhere(['id' => $id]);
        }
        if ($categoryId !== null) {
            $tagsQuery->andWhere(['categoryId' => $categoryId]);
        }
        return $this->render('index', [
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
        $tag = new Tag();
        $result = $this->handleElement($tag);
        if ($result === true) {
            return $this->redirect(['tag/index']);
        } else {
            list($tag, $slugForm) = $result;
        }
        $categoriesQuery = Category::find()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'tag' => $tag,
            'slugForm' => $slugForm,
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
        $result = $this->handleElement($tag);
        if ($result === true) {
            return $this->redirect(['tag/index']);
        } else {
            list($tag, $slugForm) = $result;
        }
        $categoriesQuery = Category::find()->orderBy(['name' => SORT_ASC]);
        $typesQuery = Type::find()->orderBy(['name' => SORT_ASC]);
        return $this->render('form', [
            'tag' => $tag,
            'slugForm' => $slugForm,
            'categoriesQuery' => $categoriesQuery,
            'typesQuery' => $typesQuery,
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
            $slug = $tag->getSlug()->one();
            if ($slug !== null) {
                $slug->delete();
            }
            $tag->delete();
        }
        return $this->redirect(['tag/index']);
    }

    public function actionBlocs($id = null)
    {
        $params = Yii::$app->request->bodyParams;
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            if ($id !== null) {
                $tag = Tag::findOne(['id' => $id]);
                if ($tag === null) {
                    throw new NotFoundHttpException();
                }
            } else {
                $tag = new Tag();
            }
            $tag->load(Yii::$app->request->bodyParams);
        }
    }
    /**
     * @param ElementInterface $element
     * @return array|bool
     * @throws ErrorException
     * @throws \yii\db\Exception
     */
    protected function handleElement(ElementInterface $element)
    {
        $slugForm = new SlugForm(['element' => $element]);
        if (Yii::$app->request->isPost) {
            $element->load(Yii::$app->request->bodyParams);
            $slugForm->multiLoad(Yii::$app->request->bodyParams);
            if ($element->validate() && $slugForm->preValidate()) {
                $transaction = Yii::$app->getDb()->beginTransaction();
                $slugFormStatus = $slugForm->save();
                $tagStatus = $element->save();
                if ($slugFormStatus && $tagStatus) {
                    if ($slugForm->hasSlug) {
                        $element->attachSlug($slugForm->getSlug());
                    } else {
                        $element->detachSlug();
                    }
                    $transaction->commit();
                    return true;
                } else {
                    $transaction->rollBack();
                    throw new ErrorException();
                }
            }
        }
        return [$element, $slugForm];
    }
}
