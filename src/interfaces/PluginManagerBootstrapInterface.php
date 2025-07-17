<?php
/**
 * PluginManagerBootstrapInterface.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\interfaces;

use blackcube\admin\Module;
use yii\base\Application;

/**
 * Interface PluginManagerBootstrapInterface
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
interface PluginManagerBootstrapInterface {
    
    /**
     * @param Module $module Admin module
     * @param Application $app
     */
    public function bootstrapAdmin(Module $module, Application $app);

}
