<?php
/**
 * AdministratorController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\commands;

use blackcube\admin\components\Rbac;
use blackcube\admin\models\Administrator;
use blackcube\admin\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;

/**
 * Blackcube admin Administrator manager
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class AdministratorController extends Controller
{

    /**
     * List registered administrators
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $this->stdout(Module::t('console', 'Administrators list'."\n"));
        $administratorsQuery = Administrator::find()->orderBy(['email' => SORT_ASC]);
        foreach($administratorsQuery->each() as $administrator) {
            /* @var $administrator Administrator */
            $this->stdout($administrator->email.' ( ');
            if ($administrator->active == true) {
                $this->stdout( Module::t('console', 'Active'));
            } else {
                $this->stdout( Module::t('console', 'Inactive'));
            }
            $this->stdout( " )\n");
        }
        return ExitCode::OK;
    }
    /**
     * Create a new administrator with role ADMIN
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionCreate()
    {
        $this->stdout(Module::t('console', 'Create new administrator'."\n"));
        $email = $this->prompt("\t".Module::t('console', 'email').' : ');
        $password = $this->prompt("\t".Module::t('console', 'password').' : ');
        $firstname = $this->prompt("\t".Module::t('console', 'firstname').' : ');
        $lastname = $this->prompt("\t".Module::t('console', 'lastname').' : ');
        $administrator = Yii::createObject(Administrator::class);
        $administrator->scenario = Administrator::SCENARIO_CREATE;
        $administrator->email = $email;
        $administrator->password = $password;
        $administrator->firstname = $firstname;
        $administrator->lastname = $lastname;
        $administrator->active = true;
        if ($administrator->validate() === true && $administrator->save() === true) {
            $this->stdout(Module::t('console', 'Save administrator {email} {hash}', [
                'email' => $administrator->email,
                'hash' => $administrator->password
            ])."\n");
        } else {
            $this->stdout(Module::t('console','Administrator is invalid')."\n");
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $role = Yii::$app->authManager->getRole(Rbac::ROLE_ADMIN);
        if ($role !== null) {
            Yii::$app->authManager->assign($role, $administrator->id);
        }
        return ExitCode::OK;
    }
}
