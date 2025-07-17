<?php
/**
 * Bo.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use yii\web\View;
use Yii;

/**
 * Class Bo
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class Bo
{
    /**
     * Register additional assets needed by admin interface.
     * @param ElementInterface|Tag|Category|Node|Composite $element
     * @param View $view
     */
    public static function registerExternalAssets($element, View $view) {
        $additionalAssets = Module::getInstance()->additionalAssets;
        foreach($additionalAssets as $key => $types) {
            if (is_int($key) && is_string($types)) {
                $className = $types;
                if (class_exists($className) === true) {
                    $className::register($view);
                } else {
                    Yii::error(Module::t('helpers', 'Class "{classname}" does not exist.', ['classname' => $className]));
                }

            } elseif (is_string($key) && is_array($types)) {
                if ($element->type !== null) {
                    $register = false;
                    foreach($element->type->getBlocTypes()->each() as $blocType) {
                        /* @var $blocType \blackcube\core\models\BlocType */
                        if (in_array($blocType->id, $types) || in_array($blocType->name, $types)) {
                            $register = true;
                            break;
                        }
                    }
                    if ($register === true) {
                        $className = $key;
                        if (class_exists($className) === true) {
                            $className::register($view);
                        } else {
                            Yii::error(Module::t('helpers', 'Class "{classname}" does not exist.', ['classname' => $className]));
                        }
                    }
                }
            }
        }
    }
}
