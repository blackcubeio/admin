<?php
/**
 * Header.php
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
use blackcube\core\components\PreviewManager;
use yii\base\Widget;
use Yii;

/**
 * Widget Header
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
class Header extends Widget
{
    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $previewManager = Yii::createObject(PreviewManager::class);
        $searchForm = Yii::createObject(SearchForm::class);
        return $this->render('header', [
            'previewManager' => $previewManager,
            'searchForm' => $searchForm,
        ]);
    }
}
