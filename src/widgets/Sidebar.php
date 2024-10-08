<?php
/**
 * Sidebar.php
 *
 * PHP version 8.0+
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
use blackcube\admin\Module;
use yii\base\Widget;
use Yii;

/**
 * Widget Sidebar
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
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
        $modules = Module::getInstance()->getModules();
        $adminModuleId = Module::getInstance()->getUniqueId();
        $version = Module::getInstance()->version;;
        $widgets = [];
        $modulesWidgets = [];
        foreach($modules as $id => $module) {
            if (is_array($module) === true) {
                $moduleClass = $module['class'];
            } else {
                $moduleClass = get_class($module);
            }
            if (is_subclass_of($moduleClass, MenuInterface::class) === true) {
                $widget = $moduleClass::getMenuWidget($adminModuleId.'/'.$id);
                if (isset($widget['class']) || isset($widget['__class'])) {
                    $widgets[] = $widget;
                }
            }

        }
        //TODO: add current module uniqueId + controllerId to match display to avoid collide with external modules
        return $this->render('sidebar', [
            'adminUid' => Module::getInstance()->getUniqueId(),
            'controllerUid' => Yii::$app->controller->getUniqueId(),
            'version' => $version,
            'widgets' => $widgets,
        ]);
    }
}
