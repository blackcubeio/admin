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
     * @inheritdoc}
     */
    public $controllerNamespace = 'blackcube\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = 'main';
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        Yii::setAlias('@blackcube/admin', __DIR__);
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
        $app->controllerMap['bc:admin'] = [
            'class' => AdministratorController::class,
        ];
        $app->controllerMap['blackcube:administrator'] = [
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
