<?php
/**
 * Header.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
