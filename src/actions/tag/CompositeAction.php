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

namespace blackcube\admin\actions\tag;

use blackcube\admin\actions\BaseElementAction;
use blackcube\core\models\CompositeTag;
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
