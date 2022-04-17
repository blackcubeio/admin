<?php
/**
 * LoginAction.php
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

use blackcube\admin\models\Administrator;
use yii\base\Action;
use Yii;

/**
 * Class LoginAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\authentication
 */
class LoginAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'login';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'dashboard/';

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $administrator = Yii::createObject(Administrator::class);
        /* @var $administrator Administrator */
        $administrator->scenario = Administrator::SCENARIO_LOGIN;
        if ($administrator->load(Yii::$app->request->bodyParams) === true) {
            if ($administrator->validate() === true) {
                $realAdministrator = Administrator::find()
                    ->where(['email' => $administrator->email])
                    ->one();
                $duration = ($administrator->rememberMe > 0) ? (60 * 60 * 24 * 30) : 0;
                Yii::$app->user->login($realAdministrator, $duration);
                return $this->controller->redirect([$this->targetAction]);
            }
            $administrator->password = null;
        }
        return $this->controller->render($this->view, [
            'administrator' => $administrator
        ]);
    }
}
