<?php
/**
 * Aurelia.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * Class Aurelia
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class Aurelia
{
    public static function component($tag, $content = '', $options = [])
    {
        $options = self::bindElementOptions($options);
        return Html::tag($tag, $content, $options);
    }


    /**
     * Prepare AureliaCustomAttribute parameters
     *
     * @param array $parameters
     * @return array
     * @since XXX
     */
    private static function bindElementOptions($options = [])
    {
        $finalOptions = [];
        foreach ($options as $key => $value) {
            if (isset($value)) {
                if ( strpos($key, '.bind') !== false) {
                    $key = Inflector::camel2id($key);
                    if (is_bool($value)) {
                        $value = $value ? 'true' : 'false';
                    // } elseif(is_string($value)) {
                    //    $value = '\'' . $value .'\'';
                    } elseif (is_numeric($value) || is_array($value) || is_string($value)) {
                        $value = '' . Json::encode($value) .'';
                    }
                }
                $finalOptions[$key] = $value;
            }
        }
        return $finalOptions;
    }
    /**
     * Prepare AureliaCustomAttribute parameters
     *
     * @param array $parameters
     * @return string
     * @since XXX
     */
    public static function bindOptions($options = [])
    {
        $aureliaParameters = '';
        $finalOptions = [];
        foreach ($options as $key => $value) {
            if (isset($value)) {
                if ( strpos($key, '.bind') !== false) {
                    $key = Inflector::camel2id($key);
                    if (is_bool($value)) {
                        $value = $value ? 'true' : 'false';
                    // } elseif(is_string($value)) {
                    //    $value = '\'' . $value .'\'';
                    } elseif (is_numeric($value) || is_array($value) || is_string($value)) {
                        $value = '' . Json::encode($value) .'';
                    }
                }
                $finalOptions[$key] = $value;
            }
        }
        foreach ($finalOptions as $key => $value) {
            $aureliaParameters .= $key.': '.$value.';';
        }
        return $aureliaParameters;
    }
}