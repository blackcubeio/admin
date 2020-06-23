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

use blackcube\admin\actions\BaseElementAction;
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
class CompositesAction extends BaseElementAction
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
            $node = $this->getNodeQuery()->andWhere(['id' => $id])->one();
            if ($node === null) {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['compositeAdd'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeAdd']])->one();
                if ($composite !== null) {
                    $node->attachComposite($composite, -1);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDelete'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeDelete']])->one();
                if ($composite !== null) {
                    $node->detachComposite($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeUp'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeUp']])->one();
                if ($composite !== null) {
                    $node->moveCompositeUp($composite);
                }
            } elseif (isset(Yii::$app->request->bodyParams['compositeDown'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeDown']])->one();
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
