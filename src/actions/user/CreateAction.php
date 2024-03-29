<?php
/**
 * CreateAction.php
 *
 * PHP version 8.0+
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
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */
class CreateAction extends Action
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
     * @param Administrator $user
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Administrator $user)
    {
        $user = Yii::createObject(Administrator::class);
        $passwordSecurity = Yii::createObject('passwordSecurity');
        if (Yii::$app->request->isPost) {
            $user->setScenario(Administrator::SCENARIO_CREATE_ONLINE);
            $user->load(Yii::$app->request->bodyParams);
            if ($user->validate() === true) {
                if (empty($user->newPassword) === false) {
                    $user->password = $user->newPassword;
                }
                if ($user->save()) {
                    return $this->controller->redirect([$this->targetAction, 'id' => $user->id]);
                }
            }
            $user->checkPassword = '';
        }
        return $this->controller->render($this->view, [
            'user' => $user,
            'passwordSecurity' => $passwordSecurity
        ]);
    }
}
