<?php
/**
 * LogoutAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\authentication
 */

namespace blackcube\admin\actions\authentication;

use yii\base\Action;
use Yii;

/**
 * Class LogoutAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\authentication
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
