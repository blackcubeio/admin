<?php
/**
 * CompositesAction.php
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

use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CompositesAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class CompositesAction extends Action
{
    /**
     * @var string view
     */
    public $view = '_composites';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        if (Yii::$app->request->isPost) {
            $node = Node::findOne(['id' => $id]);
            if ($node === null) {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['compositeAdd'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeAdd']])->one();
                if ($composite !== null) {
                    $node->attachComposite($composite, -1);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDelete'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeDelete']])->one();
                if ($composite !== null) {
                    $node->detachComposite($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeUp'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeUp']])->one();
                if ($composite !== null) {
                    $node->moveCompositeUp($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDown'])) {
                $composite = Composite::find()->andWhere(['id' => Yii::$app->request->bodyParams['compositeDown']])->one();
                if ($composite !== null) {
                    $node->moveCompositeDown($composite);
                }
            }
            $compositesQuery = $node->getComposites();
            return $this->controller->renderPartial($this->view, [
                'compositesQuery' => $compositesQuery,
                'element' => $node
            ]);
        }
    }
}
