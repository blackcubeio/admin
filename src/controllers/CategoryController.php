<?php

namespace blackcube\admin\controllers;

use blackcube\core\models\Category;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class CategoryController extends Controller
{

    public function actionIndex($id = null)
    {
        $categoriesQuery = Category::find()->orderBy(['name' => SORT_ASC]);
        if ($id !== null) {
            $categoriesQuery->andWhere(['id' => $id]);
        }
        return $this->render('index', [
            'categoriesQuery' => $categoriesQuery
        ]);
    }

    public function actionEdit($id)
    {
        $category = Category::findOne(['id' => $id]);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $category->load(Yii::$app->request->bodyParams);
            if ($category->save()) {
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('form', [
            'category' => $category
        ]);
    }

    public function actionDelete($id)
    {
        $category = Category::findOne(['id' => $id]);
        if ($category === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $category->delete();
        }
        return $this->redirect(['category/index']);
    }

    public function actionCreate()
    {
        $category = new Category();
        if (Yii::$app->request->isPost) {
            $category->load(Yii::$app->request->bodyParams);
            if ($category->save()) {
                return $this->redirect(['category/index']);
            }
        }
        return $this->render('form', [
            'category' => $category
        ]);
    }
}
