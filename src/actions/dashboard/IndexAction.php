<?php
/**
 * IndexAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\dashboard
 */

namespace blackcube\admin\actions\dashboard;

use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\dashboard
 */
class IndexAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'index';

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $compositesQuery = Composite::find()
            ->orderBy(['dateUpdate' => SORT_DESC, 'dateCreate' => SORT_DESC])
            ->limit(5);
        $nodesQuery = Node::find()
            ->orderBy(['dateUpdate' => SORT_DESC, 'dateCreate' => SORT_DESC])
            ->limit(5);
        $categoriesQuery = Category::find()
            ->orderBy(['dateUpdate' => SORT_DESC, 'dateCreate' => SORT_DESC])
            ->limit(5);
        $tagsQuery = Tag::find()
            ->orderBy(['dateUpdate' => SORT_DESC, 'dateCreate' => SORT_DESC])
            ->limit(5);

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
        return $this->controller->render($this->view, [
            'countComposites' => $countComposites,
            'countNodes' => $countNodes,
            'countCategories' => $countCategories,
            'countTags' => $countTags,
            'nodesQuery' => $nodesQuery,
            'compositesQuery' => $compositesQuery,
            'categoriesQuery' => $categoriesQuery,
            'tagsQuery' => $tagsQuery,
        ]);
    }
}
