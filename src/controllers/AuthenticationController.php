<?php
/**
 * AuthenticationController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */

namespace blackcube\admin\controllers;

use blackcube\admin\models\Administrator;
use yii\web\Controller;
use Yii;

/**
 * Class AuthenticationController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class AuthenticationController extends Controller
{
    /**
     * {@inheritDoc}
     */
    public $layout = 'main-login';

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionLogin()
    {
        $administrator = Yii::createObject(Administrator::class);
        /* @var $administrator Administrator */
        $administrator->scenario = Administrator::SCENARIO_LOGIN;
        if ($administrator->load(Yii::$app->request->bodyParams) === true) {
            if ($administrator->validate() === true) {
                $realAdministrator = Administrator::find()->where(['email' => $administrator->email])->one();
                Yii::$app->user->login($realAdministrator, 60 * 60 *24 * 30);
                return $this->redirect(['default/']);
                // $realAdministrator = $administrator::
            }
        }
        return $this->render('login', [
            'administrator' => $administrator
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['login']);
    }
}
