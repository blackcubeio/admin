<?php
/**
 * PluginModule.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\components
 */

namespace blackcube\admin\components;

use blackcube\admin\interfaces\PluginModuleBootstrapInterface;
use blackcube\core\interfaces\PluginModuleBootstrapInterface as CorePluginModuleBootstrapInterface;
use yii\base\Module;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

/**
 * PluginModule
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\components
 */
abstract class PluginModule extends Module implements PluginModuleBootstrapInterface, CorePluginModuleBootstrapInterface {

    const MODE_FRONT = 'front';
    const MODE_ADMIN = 'admin';

    /**
     * @var string current module mode
     */
    public $mode;

    /**
     * @var string admin controller namespace
     */
    public $adminControllerNamespace;

    /**
     * @var string front controller namespace
     */
    public $frontControllerNamespace;

    /**
     * @var string admin view path alias
     */
    public $adminViewPath;

    /**
     * @var string front view path alias
     */
    public $frontViewPath;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->mode === self::MODE_ADMIN && $this->adminControllerNamespace !== null) {
            $this->controllerNamespace = $this->adminControllerNamespace;
        } elseif ($this->mode === self::MODE_FRONT && $this->frontControllerNamespace !== null) {
            $this->controllerNamespace = $this->frontControllerNamespace;
        }
        if ($this->mode === self::MODE_ADMIN && $this->adminViewPath !== null) {
            $this->viewPath = $this->adminViewPath;
        } elseif ($this->mode === self::MODE_FRONT && $this->frontViewPath !== null) {
            $this->viewPath = $this->frontViewPath;
        }
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($this->mode === self::MODE_FRONT) {
            if ($app instanceof ConsoleApplication) {
                $this->bootstrapConsole($app);
            } elseif ($app instanceof WebApplication) {
                $this->bootstrapWeb($app);
            }
        } elseif ($this->mode === self::MODE_ADMIN) {
            if ($app instanceof ConsoleApplication) {
                $this->bootstrapAdminConsole($app);
            } elseif ($app instanceof WebApplication) {
                $this->bootstrapAdminWeb($app);
            }
        }
    }

    /**
     * Bootstrap console stuff
     *
     * @param ConsoleApplication $app
     * @since XXX
     */
    abstract public function bootstrapConsole(ConsoleApplication $app);

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    abstract public function bootstrapWeb(WebApplication $app);

    /**
     * Bootstrap console stuff
     *
     * @param ConsoleApplication $app
     * @since XXX
     */
    abstract public function bootstrapAdminConsole(ConsoleApplication $app);

    /**
     * Bootstrap web stuff
     *
     * @param WebApplication $app
     * @since XXX
     */
    abstract public function bootstrapAdminWeb(WebApplication $app);

}
