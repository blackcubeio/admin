<?php
/**
 * RbacAction.php
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
use blackcube\admin\helpers\User as UserHelper;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class RbacAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class RbacAction extends Action
{
    /**
     * @var string view
     */
    public $view = '_roles';

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
        $updated = false;
        if (Yii::$app->user->id !== $user->id) {
            if (Yii::$app->request->isPost) {

                $itemName = Yii::$app->request->getBodyParam('name', null);
                $itemType = Yii::$app->request->getBodyParam('type', null);
                $itemMode = Yii::$app->request->getBodyParam('mode', null);
                if ($itemName !== null && $itemType !== null && $itemMode !== null) {
                    $item = null;
                    if ($itemType === 'role') {
                        $item = Yii::$app->authManager->getRole($itemName);
                    } elseif ($itemType === 'permission') {
                        $item = Yii::$app->authManager->getPermission($itemName);
                    }
                    if ($item !== null && $itemMode === 'add') {
                        Yii::$app->authManager->assign($item, $user->id);
                        $updated = true;
                    } elseif ($item !== null && $itemMode === 'remove') {
                        Yii::$app->authManager->revoke($item, $user->id);
                        $updated = true;
                    }
                }
            }
        }
        $loggedId = Yii::$app->user->getId();
        $canAssign = $loggedId !== $user->id;
        $authorizationData = UserHelper::prepareAuthorizationData($user->id);

        return $this->controller->renderPartial($this->view, [
            'user' => $user,
            'updated' => $updated,
            'userRolesById' => $authorizationData['userRolesById'],
            'userPermissionsById' => $authorizationData['userPermissionsById'],
            'userAssignmentsById' => $authorizationData['userAssignmentsById'],
            'canAssign' => $canAssign,
        ]);
    }
}
