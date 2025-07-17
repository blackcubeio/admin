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

namespace blackcube\admin\actions\parameter;

use blackcube\core\models\Parameter;
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
