<?php
/**
 * ElementListHeader.php
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

use blackcube\admin\models\SearchForm;
use blackcube\admin\Module;
use blackcube\core\components\PreviewManager;
use yii\base\Widget;
use Yii;

/**
 * Widget ElementListHeader
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
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
