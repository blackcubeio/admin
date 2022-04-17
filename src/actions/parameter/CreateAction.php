<?php
/**
 * CreateAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\parameter
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
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\parameter
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
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $parameter = Yii::createObject(Parameter::class);
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
