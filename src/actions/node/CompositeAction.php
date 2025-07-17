<?php
/**
 * CompositeAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\actions\BaseElementAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CompositeAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class CompositeAction extends BaseElementAction
{
    /**
     * @var string
     */
    public $elementClass;

    /**
     * @var string
     */
    public $view = '@blackcube/admin/views/common/_composites';

    /**
     * @param null $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id = null)
    {
        if (Yii::$app->request->isPost) {
            $node = $this->getNodeQuery()->andWhere(['id' => $id])->one();
            if ($node === null) {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['compositeDetach'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeDetach']])->one();
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
        }
        return $this->controller->renderPartial($this->view, [
            'element' => $node
        ]);
    }
}
