<?php
/**
 * EditAction.php
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

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class EditAction extends BaseElementAction
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
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $node = $this->getNodeQuery()
            ->andWhere(['id' => $id])
            ->one();

        if ($node === null) {
            throw new NotFoundHttpException();
        }
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $node
        ]);

        $parentNode = $node->getParent()->one();
        $blocs = $node->getBlocs()->all();
        $compositesQuery = $node->getComposites();
        if (Yii::$app->request->isPost) {
            $moveNode =  Yii::$app->request->getBodyParam('moveNode', false);
            if ($moveNode == true) {
                $newTargetNodeId = Yii::$app->request->getBodyParam('moveNodeTarget', null);
                $moveNodeTarget = Node::findOne(['id' => $newTargetNodeId]);
                $moveNodeMode =  Yii::$app->request->getBodyParam('moveNodeMode', 'into');
                if ($moveNodeTarget === null) {
                    $moveNode = false;
                }
            }
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
        }
        try {
            if (isset($moveNode) && $moveNode == true && isset($moveNodeTarget, $moveNodeMode)) {
                switch ($moveNodeMode) {
                    case 'into':
                        $node->moveInto($moveNodeTarget);
                        break;
                    case 'before':
                        $node->moveBefore($moveNodeTarget);
                        break;
                    case 'after':
                        $node->moveAfter($moveNodeTarget);
                        break;
                }
            }
            $result = NodeHelper::saveElement($node, $blocs, $slugForm);
            if (Yii::$app->request->isPost) {
                $transaction->commit();
            }
        } catch(\Exception $e) {
            $result = false;
            if (Yii::$app->request->isPost) {
                $transaction->rollBack();
            }
        }
        if ($result === true) {
            $selectedTags = Yii::$app->request->getBodyParam('selectedTags', []);
            NodeHelper::handleTags($node, $selectedTags);
            return $this->controller->redirect([$this->targetAction, 'id' => $node->id]);
        }
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $targetNodesQuery = $this->getTargetNodesQuery()
            ->orderBy(['left' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);

        $selectTagsData = NodeHelper::prepareTags();

        return $this->controller->render($this->view, [
            'node' => $node,
            'parentNode' => $parentNode,
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
