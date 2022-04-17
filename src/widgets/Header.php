<?php
/**
 * Header.php
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

use blackcube\admin\models\SearchForm;
use blackcube\admin\Module;
use blackcube\core\components\PreviewManager;
use yii\base\Widget;
use Yii;

/**
 * Widget Header
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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

        $currentModuleUid = Module::getInstance()->getUniqueId();
        return $this->render('header', [
            'currentModuleUid' => '/'.$currentModuleUid,
            'previewManager' => $previewManager,
            'searchForm' => $searchForm,
        ]);
    }
}
