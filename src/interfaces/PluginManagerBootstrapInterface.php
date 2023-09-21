<?php
/**
 * PluginManagerBootstrapInterface.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */

namespace blackcube\admin\interfaces;

use blackcube\admin\Module;
use yii\base\Application;

/**
 * Interface PluginManagerBootstrapInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\core\interfaces
 */
interface PluginManagerBootstrapInterface {
    
    /**
     * @param Module $module Admin module
     * @param Application $app
     */
    public function bootstrapAdmin(Module $module, Application $app);

}
