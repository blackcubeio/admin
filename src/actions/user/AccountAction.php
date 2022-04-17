<?php
/**
 * AccountAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
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
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
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
        if ($user === null) {
            throw new NotFoundHttpException();
        }
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

        return $this->controller->render($this->view, [
            'user' => $user,
        ]);
    }
}
