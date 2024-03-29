<?php
/**
 * ModuleMenuInterface.php
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

/**
 * Interface ModuleMenuInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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
