<?php
/**
 * PluginModuleBootstrapInterface.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */

namespace blackcube\admin\interfaces;

use yii\base\BootstrapInterface;
use yii\web\Application as WebApplication;
use yii\console\Application as ConsoleApplication;

/**
 * Interface PluginModuleBootstrapInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */
interface PluginModuleBootstrapInterface extends BootstrapInterface {

    /**
     * Bootstrap web module
     * @param WebApplication $app
     */
    public function bootstrapAdminWeb(WebApplication $app);

    /**
     * Bootstrap console module
     * @param ConsoleApplication $app
     */
    public function bootstrapAdminConsole(ConsoleApplication $app);
}
