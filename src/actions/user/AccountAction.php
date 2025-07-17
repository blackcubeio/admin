<?php
/**
 * AccountAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\models\Administrator;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class AccountAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class AccountAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'form_account';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'account';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $user = Yii::$app->user->identity;
        /* @var Administrator $user */
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        $passwordSecurity = Yii::createObject('passwordSecurity');
        if (Yii::$app->request->isPost) {
            $user->setScenario(Administrator::SCENARIO_UPDATE);
            $user->load(Yii::$app->request->bodyParams);
            if ($user->validate() === true) {
                if (empty($user->newPassword) === false) {
                    $user->password = $user->newPassword;
                }
                if ($user->save()) {
                    $user->newPassword = '';
                    return $this->controller->redirect([$this->targetAction]);
                }
            }
            $user->checkPassword = '';
        }
        $passkeysQuery = $user->getPasskeys();

        return $this->controller->render($this->view, [
            'user' => $user,
            'passwordSecurity' => $passwordSecurity,
            'passkeysQuery' => $passkeysQuery,
        ]);
    }
}
