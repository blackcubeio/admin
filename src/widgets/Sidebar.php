<?php
/**
 * Sidebar.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */

namespace blackcube\admin\widgets;

use yii\base\Widget;
use Yii;

/**
 * Widget Sidebar
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
class Sidebar extends Widget
{

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->render('sidebar', [
            'controller' => Yii::$app->controller->id,
        ]);
    }
}
