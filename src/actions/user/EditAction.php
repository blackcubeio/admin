<?php
/**
 * EditAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */

namespace blackcube\admin\actions\user;

use blackcube\admin\helpers\User as UserHelper;
use blackcube\admin\models\Administrator;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\user
 */
class EditAction extends Action
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
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $user = Administrator::findOne(['id' => $id]);
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
                    return $this->controller->redirect([$this->targetAction, 'id' => $user->id]);
                }
            }
            $user->checkPassword = '';
        }
        $authorizationData = UserHelper::prepareAuthorizationData($user->id);

        return $this->controller->render('form', [
            'user' => $user,
            'userRolesById' => $authorizationData['userRolesById'],
            'userPermissionsById' => $authorizationData['userPermissionsById'],
            'userAssignmentsById' => $authorizationData['userAssignmentsById'],
        ]);
    }
}
