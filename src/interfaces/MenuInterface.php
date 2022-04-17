<?php
/**
 * MenuInterface.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */

namespace blackcube\admin\interfaces;

use yii\base\Widget;
use Yii;

/**
 * Interface MenuInterface
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\interfaces
 */
interface MenuInterface {

    /**
     * @param string $moduleUniqueId Module implementing the widget uniqueId
     * @return Widget
     */
    public static function getMenuWidget($moduleUniqueId);
}
