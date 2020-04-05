<?php
/**
 * Module.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\core
 */

namespace blackcube\admin;

use blackcube\admin\commands\AdministratorController;
use blackcube\admin\commands\IconsController;
use yii\base\BootstrapInterface;
use yii\base\Module as BaseModule;
use yii\db\Connection;
use yii\di\Instance;
use yii\rbac\DbManager;
use yii\web\Application as WebApplication;
use yii\console\Application as ConsoleApplication;
use Exception;
use Yii;



/**
 * Class module
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\core
 */
class Module extends BaseModule implements BootstrapInterface
{

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'blackcube\admin\controllers';

    /**
     * @var string alias of the directory where we can find bloc templates for admin display
     */
    public $adminTemplatesAlias;

    /**
     * @var Connection|array|string database access
     */
    public $db = 'db';

    /**
     * @var string command prefix
     */
    public $commandNameSpace = 'bc:';


    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();
        $this->db = Instance::ensure($this->db, Connection::class);
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@blackcube/admin', __DIR__);
        $app->setComponents([
            'authManager' => [
                'class' => DbManager::class,
                'db' => $app->db,
            ]
        ]);
        if ($app instanceof ConsoleApplication) {
            $this->bootstrapConsole($app);
        } elseif ($app instanceof WebApplication) {
            $this->bootstrapWeb($app);
        }
    }

    /**
     * Bootstrap console stuff
     *
     * @param ConsoleApplication $app
     * @since XXX
     */
    protected function bootstrapConsole(ConsoleApplication $app)
    {
        $app->controllerMap[$this->commandNameSpace.'admin'] = [
            'class' => AdministratorController::class,
        ];
        $app->controllerMap['bc:icons'] = [
            'class' => IconsController::class,
        ];

    }

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    protected function bootstrapWeb(WebApplication $app)
    {

    }

}
