<?php
/**
 * Html.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\core\interfaces\ElasticInterface;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * Class Html
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class Tailwind extends Html
{
    /**
     * {@inheritDoc}
     * $options [
     *      'errorClass' => 'error-cls',
     *      'accessory' => [
     *          'options' => [
     *              'closs' => 'accessory-cls',
     *          ],
     *          'icon' => [
     *              'icon' => 'solid/exclamation-circle', // Heroicon name
     *              'options' => []
     *          ]
     *          'wrapperOptions' => [
     *              'closs' => 'wrapper-cls',
     *          ]
     *      ],
     * ]
     */
    public static function activeTextInput($model, $attribute, $options = [])
    {
        $accessoryOptions = self::prepareActiveAccessoryOptions($model, $attribute, $options);
        $input = parent::activeTextInput($model, $attribute, $options);
        return self::buildActiveField($model, $attribute, $input, $accessoryOptions);
    }

    public static function activePasswordInput($model, $attribute, $options = [])
    {
        $accessoryOptions = self::prepareActiveAccessoryOptions($model, $attribute, $options);
        $input = parent::activePasswordInput($model, $attribute, $options);
        return self::buildActiveField($model, $attribute, $input, $accessoryOptions);
    }

    protected static function buildActiveField($model, $attribute, $input, $options = [])
    {
        $accessory = '';
        if($options['icon'] !== null) {
            if($model->hasErrors($attribute) === true) {
                $accessory = "\n" . parent::tag('div', Heroicons::svg($options['icon'], $options['iconOptions']), $options['wrapperOptions']);
            }
        }
        return parent::tag('div', $input."\n".$accessory, $options['wrapperOptions']);
    }

    protected static function prepareActiveAccessoryOptions($model, $attribute, &$options = [])
    {
        $errorClass = $options['errorClass'] ?? '';
        $accessoryOptions = $options['accessory']['options'] ?? [];
        $accessoryIcon = $options['accessory']['icon']['icon'] ?? null;
        $accessoryIconOptions = $options['accessory']['icon']['options'] ?? [];
        $wrapperOptions = $options['accessory']['wrapperOptions'] ?? [];
        unset($options['error'], $options['accessory']);

        if($model->hasErrors($attribute) === true) {
            if (isset($options['class']) === false) {
                $options['class'] = $errorClass;
            } else {
                $options['class'] .= ' ' .$errorClass;
            }
        }

        return [
            'errorClass' => $errorClass,
            'icon' => $accessoryIcon,
            'iconOptions' => $accessoryIconOptions,
            'options' => $accessoryOptions,
            'wrapperOptions' => $wrapperOptions,
        ];
    }
}