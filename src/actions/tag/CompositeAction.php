<?php
/**
 * CompositeAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\tag
 */

namespace blackcube\admin\actions\tag;

use blackcube\admin\actions\BaseElementAction;
use blackcube\core\models\CompositeTag;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CompositeAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\tag
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
            $tag = $this->getTagQuery()->andWhere(['id' => $id])->one();
            if ($tag === null) {
                throw new NotFoundHttpException();
            }
            if (isset(Yii::$app->request->bodyParams['compositeDetach'])) {
                $compositeQuery = $this->getCompositeQuery();
                $composite = $compositeQuery
                    ->andWhere(['id' => Yii::$app->request->bodyParams['compositeDetach']])->one();
                if ($composite !== null) {
                    $compositeTag = CompositeTag::find()
                        ->andWhere([
                            'tagId' => $tag->id,
                            'compositeId' => $composite->id
                        ])
                        ->one();
                    if ($compositeTag !== null) {
                        $compositeTag->delete();
                    }
                }
            }
        }
        return $this->controller->renderPartial($this->view, [
            'element' => $tag
        ]);
    }
}
