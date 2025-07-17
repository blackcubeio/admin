<?php
/**
 * LogoutAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\authentication;

use yii\base\Action;
use Yii;

/**
 * Class LogoutAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class LogoutAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'login';

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        Yii::$app->user->logout();
        return $this->controller->redirect([$this->targetAction]);
    }
}
