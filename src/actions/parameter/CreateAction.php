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

namespace blackcube\admin\actions\parameter;

use blackcube\core\models\Parameter;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use blackcube\core\Module as CoreModule;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
     * @param Parameter $parameter
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Parameter $parameter)
    {
        if (Yii::$app->request->isPost) {
            $parameter->load(Yii::$app->request->bodyParams);
            if ($parameter->validate() === true) {
                if ($parameter->save()) {
                    return $this->controller->redirect([$this->targetAction, 'domain' => $parameter->domain, 'name' => $parameter->name]);
                }
            }
        }
        $allowedParameterDomains = CoreModule::getInstance()->allowedParameterDomains;

        return $this->controller->render($this->view, [
            'parameter' => $parameter,
            'allowedParameterDomains' => $allowedParameterDomains
        ]);
    }
}
