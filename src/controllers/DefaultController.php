<?php

namespace blackcube\admin\controllers;

use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{

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
    public function actionTest()
    {
        return $this->render('test', []);
    }
}
