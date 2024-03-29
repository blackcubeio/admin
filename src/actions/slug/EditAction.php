<?php
/**
 * EditAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */

namespace blackcube\admin\actions\slug;

use blackcube\core\models\Slug;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\slug
 */
class EditAction extends Action
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
        $slug = Slug::findOne(['id' => $id]);
        if ($slug === null) {
            throw new NotFoundHttpException();
        }
        if ($slug->element === null) {
            $slug->setScenario(Slug::SCENARIO_REDIRECT);
        }

        if (Yii::$app->request->isPost) {
            $slug->load(Yii::$app->request->bodyParams);
            if ($slug->save()) {
                return $this->controller->redirect([$this->targetAction, 'id' => $slug->id]);
            }
        }
        return $this->controller->render($this->view, [
            'element' => $slug,
        ]);
    }
}
