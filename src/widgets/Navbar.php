<?php
/**
 * Navbar.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */

namespace blackcube\admin\widgets;

use blackcube\admin\interfaces\MenuInterface;
use blackcube\admin\interfaces\ModuleMenuInterface;
use blackcube\admin\Module;
use yii\base\Widget;
use Yii;

/**
 * Widget Navbar
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
class Navbar extends Widget
{

    public $adminUid;
    public $controllerUid;
    public $widgets;
    public $modulesWidgets;
    /**
     * {@inheritDoc}
     */
    public function run()
    {
        //TODO: add current module uniqueId + controllerId to match display to avoid collide with external modules
        return $this->render('navbar', [
            'adminUid' => $this->adminUid,
            'controllerUid' => $this->controllerUid,
            'widgets' => $this->widgets,
            'modulesWidgets' => $this->modulesWidgets,
        ]);
    }
}
