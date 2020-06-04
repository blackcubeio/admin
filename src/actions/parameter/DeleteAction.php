<?php
/**
 * DeleteAction.php
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
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\parameter
 */
class DeleteAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

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
            $parameter->delete();
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
