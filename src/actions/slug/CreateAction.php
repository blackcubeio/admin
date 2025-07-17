<?php
/**
 * CreateAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\slug;

use blackcube\admin\actions\BaseElementAction;
use blackcube\core\models\Slug;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class CreateAction extends BaseElementAction
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
     * @param Slug $slug
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Slug $slug)
    {
        $slug->setScenario(Slug::SCENARIO_REDIRECT);

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
