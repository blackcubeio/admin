<?php
/**
 * ElementListHeader.php
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
 * Widget ElementListHeader
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class ElementListHeader extends Widget
{
    /**
     * @var string
     */
    public $icon;

    /**
     * @var string
     */

    public $title;
    /**
     * {@inheritDoc}
     */
    public function run()
    {
        return $this->render('element-list-header', [
            'title' => $this->title,
            'icon' => $this->icon,
        ]);
    }
}
