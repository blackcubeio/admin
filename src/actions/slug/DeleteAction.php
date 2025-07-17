<?php
/**
 * DeleteAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\slug;

use blackcube\core\models\Slug;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class DeleteAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $slug = Slug::find()->with(['seo', 'sitemap'])->andWhere(['id' => $id])->one();
        if ($slug === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $element = $slug->element;
            if ($element !== null) {
                $element->detachSlug();
            } else {
                $slug->delete();
            }
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
