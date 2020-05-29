<?php
/**
 * AdministratorController.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\commands
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
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\commands
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
        $administrator = Yii::createObject(Administrator::class);
        $administrator->scenario = Administrator::SCENARIO_CREATE;
        $administrator->email = $email;
        $administrator->password = $password;
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
