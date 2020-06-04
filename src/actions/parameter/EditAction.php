<?php
/**
 * EditAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
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
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\parameter
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
     * @param string $domain
     * @param string $name
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($domain, $name)
    {
        $parameter = Parameter::findOne(['domain' => $domain, 'name' => $name]);
        if ($parameter === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $parameter->load(Yii::$app->request->bodyParams);
            if ($parameter->validate() === true) {
                if ($parameter->save()) {
                    return $this->controller->redirect([$this->targetAction, 'domain' => $parameter->domain, 'name' => $parameter->name]);
                }
            }
        }
        return $this->controller->render($this->view, [
            'parameter' => $parameter,
        ]);
    }
}
