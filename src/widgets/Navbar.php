<?php
/**
 * Navbar.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\widgets;

use yii\base\Widget;

/**
 * Widget Navbar
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class Navbar extends Widget
{

    public $adminUid;
    public $controllerUid;
    public $widgets;
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
        ]);
    }
}
