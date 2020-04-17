<?php
/**
 * UserController.php
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

use blackcube\admin\actions\ModalAction;
use blackcube\admin\models\Administrator;
use blackcube\admin\Module;
use blackcube\core\models\BlocType;
use blackcube\core\models\Type;
use blackcube\core\models\TypeBlocType;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\filters\AjaxFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\Response;

/**
 * Class UserController
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\controllers
 */
class UserController extends Controller
{

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'actions' => [
                        'modal', 'index', 'create', 'edit', 'delete', 'rbac', 'toggle',
                    ],
                    'roles' => ['@'],
                ]
            ]
        ];
        $behaviors['forceAjax'] = [
            'class' => AjaxFilter::class,
            'only' => ['modal', 'rbac', 'toggle'],
        ];
        return $behaviors;
    }

    /**
     * {@inheritDoc}
     */
    public function actions()
    {
        $actions = parent::actions();
        $actions['modal'] = [
            'class' => ModalAction::class,
            'elementClass' => Administrator::class
        ];
        return $actions;
    }

    /**
     * @return string|Response
     */
    public function actionIndex()
    {
        $usersQuery = Administrator::find()
            ->orderBy(['email' => SORT_ASC]);
        return $this->render('index', [
            'usersQuery' => $usersQuery
        ]);
    }

    /**
     * @return string|Response
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $user = Yii::createObject(Administrator::class);
        if (Yii::$app->request->isPost) {
            $user->setScenario(Administrator::SCENARIO_CREATE_ONLINE);
            $user->load(Yii::$app->request->bodyParams);
            $user->load(Yii::$app->request->bodyParams);
            if ($user->validate() === true) {
                $user->password = $user->newPassword;
                if ($user->save()) {
                    return $this->redirect(['edit', 'id' => $user->id]);
                }
            }
            $user->checkPassword = '';
        }
        return $this->render('form', [
            'user' => $user,
        ]);
    }

    /**
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionEdit($id)
    {
        $user = Administrator::findOne(['id' => $id]);
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $user->setScenario(Administrator::SCENARIO_UPDATE);
            $user->load(Yii::$app->request->bodyParams);
            if ($user->validate() === true) {
                $user->password = $user->newPassword;
                if ($user->save()) {
                    $user->newPassword = '';
                    // return $this->redirect(['index']);
                }
            }
            $user->checkPassword = '';
        }
        $authorizationData = $this->prepareAuthorizationData($user->id);

        return $this->render('form', [
            'user' => $user,
            'userRolesById' => $authorizationData['userRolesById'],
            'userPermissionsById' => $authorizationData['userPermissionsById'],
            'userAssignmentsById' => $authorizationData['userAssignmentsById'],
        ]);
    }

    /**
     * @param null $id
     * @return string|Response
     */
    public function actionToggle($id = null)
    {
        if ($id !== null) {
            $currenUser = Administrator::findOne(['id' => $id]);
            if ($currenUser !== null) {
                $currenUser->active = !$currenUser->active;
                $currenUser->save(false, ['active']);
            }
        }
        $usersQuery = Administrator::find()
            ->orderBy(['email' => SORT_ASC]);
        return $this->renderPartial('_list', [
            'usersQuery' => $usersQuery
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionRbac($id)
    {
        $user = Administrator::findOne(['id' => $id]);
        if ($user === null) {
            throw new NotFoundHttpException();
        }
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
                } else if ($item !== null && $itemMode === 'remove') {
                    Yii::$app->authManager->revoke($item, $user->id);
                }
            }
        }
        $authorizationData = $this->prepareAuthorizationData($user->id);

        return $this->renderPartial('_roles', [
            'user' => $user,
            'userRolesById' => $authorizationData['userRolesById'],
            'userPermissionsById' => $authorizationData['userPermissionsById'],
            'userAssignmentsById' => $authorizationData['userAssignmentsById'],
        ]);
    }

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $user = Administrator::findOne(['id' => $id]);
        if ($user === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            Yii::$app->authManager->revokeAll($user->id);
            $user->delete();
        }
        return $this->redirect(['index']);
    }

    /**
     * @param integer $userId
     * @return array
     */
    protected function prepareAuthorizationData($userId)
    {
        $authManager = Yii::$app->authManager;
        $userRoles = $authManager->getRolesByUser($userId);
        $userChildRoles = [];
        foreach($userRoles as $userRole) {
            $userChildRoles = array_merge($userChildRoles, $authManager->getChildRoles($userRole->name));
        }
        $userRolesById = array_map(function($role) {
            /* @var $role \yii\rbac\Role */
            return $role->name;
        }, $userChildRoles);
        $userPermissions = $authManager->getPermissionsByUser($userId);
        $userPermissionsById = array_map(function($permission) {
            /* @var $permission \yii\rbac\Permission */
            return $permission->name;
        }, $userPermissions);

        $userAssignments = $authManager->getAssignments($userId);
        $userAssignmentsById = array_map(function($assignment) {
            /* @var $assignment \yii\rbac\Assignment */
            return $assignment->roleName;
        }, $userAssignments);
        return [
            'userRolesById' => $userRolesById,
            'userPermissionsById' => $userPermissionsById,
            'userAssignmentsById' => $userAssignmentsById,
        ];
    }
}
