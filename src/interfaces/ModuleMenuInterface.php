<?php
/**
 * ModuleMenuInterface.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */

namespace blackcube\admin\interfaces;

use Yii;

/**
 * Interface ModuleMenuInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */
interface ModuleMenuInterface {

    /**
     * @param string $moduleUniqueId Module implementing the widget uniqueId
     * @return array [Rbac::PERMISSION => ['class' => Widget::class]]
     */
    public static function getModuleMenuWidget($moduleUniqueId);
}
