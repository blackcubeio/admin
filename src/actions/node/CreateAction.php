<?php
/**
 * CreateAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\SlugForm;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class CreateAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'form';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'edit';

    /**
     * @var callable
     */
    public $typesQuery;

    /**
     * @var callable
     */
    public $targetNodesQuery;

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $node = Yii::createObject(Node::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $node
        ]);
        $blocs = $node->getBlocs()->all();
        $compositesQuery = $node->getComposites();
        if (Yii::$app->request->isPost) {
            $targetId = Yii::$app->request->getBodyParam('moveNodeTarget');
            $saveNodeMode =  Yii::$app->request->getBodyParam('moveNodeMode', 'into');
            $targetNode = Node::findOne(['id' => $targetId]);
            $node->load(Yii::$app->request->bodyParams);
            switch ($saveNodeMode) {
                case 'into':
                    $node->saveInto($targetNode);
                    break;
                case 'before':
                    $node->saveBefore($targetNode);
                    break;
                case 'after':
                    $node->saveAfter($targetNode);
                    break;
            }

        }
        $result = NodeHelper::saveElement($node, $blocs, $slugForm);
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            NodeHelper::handleTags($node, $selectedTags);
            return $this->controller->redirect([$this->targetAction, 'id' => $node->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $targetNodesQuery = null;
        if (is_callable($this->targetNodesQuery) === true) {
            $targetNodesQuery = call_user_func($this->targetNodesQuery);
        }
        if ($targetNodesQuery === null || (($targetNodesQuery instanceof ActiveQuery) === false)) {
            $targetNodesQuery =  Node::find();
        }
        $targetNodesQuery->orderBy(['left' => SORT_ASC]);

        $typesQuery = null;
        if (is_callable($this->typesQuery) === true) {
            $typesQuery = call_user_func($this->typesQuery);
        }
        if ($typesQuery === null || (($typesQuery instanceof ActiveQuery) === false)) {
            $typesQuery = Type::find();
        }
        $typesQuery->orderBy(['name' => SORT_ASC]);

        $selectTagsData =  NodeHelper::prepareTags();

        return $this->controller->render($this->view, [
            'node' => $node,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'selectTagsData' => $selectTagsData,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'compositesQuery' => $compositesQuery,
            'languagesQuery' => $languagesQuery,
        ]);
    }
}
