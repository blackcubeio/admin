<?php
/**
 * Bo.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\interfaces\ElasticInterface;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\Inflector;
use yii\helpers\Json;
use yii\web\View;

/**
 * Class Bo
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class Bo
{
    public static function registerExternalAssets($element, View $view) {
        $additionalAssets = Module::getInstance()->additionalAssets;
        foreach($additionalAssets as $key => $types) {
            if (is_int($key) && is_string($types)) {
                $className = $types;
                $className::register($view);
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
                        $className::register($view);
                    }
                }
            }
        }
    }
}
