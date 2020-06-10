<?php
/**
 * LoginAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
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
 * @copyright 2010-2020 Redcat
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
                $realAdministrator = Administrator::find()->where(['email' => $administrator->email])->one();
                Yii::$app->user->login($realAdministrator, 60 * 60 *24 * 30);
                return $this->controller->redirect([$this->targetAction]);
                // $realAdministrator = $administrator::
            }
            $administrator->password = null;
        }
        return $this->controller->render($this->view, [
            'administrator' => $administrator
        ]);
    }
}
