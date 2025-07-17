<?php
/**
 * CreateAction.php
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
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
