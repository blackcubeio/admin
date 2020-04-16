<?php
/**
 * Html.php
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
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class Html extends \blackcube\core\web\helpers\Html
{
    /**
     * @var array
     */
    private static $icons = [
        'plus' => [
            'path' => 'M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z',
            'viewBox' => '0 0 20 20',
        ],
    ];


    /**
     * Prepare AureliaCustomAttribute parameters
     *
     * @param array $parameters
     * @return string
     * @since XXX
     */
    public static function bindAureliaAttributes($parameters = [])
    {
        $aureliaParameters = '';
        foreach ($parameters as $key => $value) {
            if (isset($value)) {
                $key = Inflector::camel2id($key);
                if (is_bool($value)) {
                    $value = $value ? '1' : '0';
                } elseif (!(is_numeric($value) || is_string($value))) {
                    $value = Json::encode($value);
                }
                //ELSE VALUE IS OK
                $aureliaParameters .= $key.'.bind: \''.$value.'\'; ';
            }
        }
        return $aureliaParameters;

    }

    /**
     * @param Model $model
     * @param string $attribute
     * @param array $options
     * @return string
     */
    public static function activeSchema(Model $model, $attribute, $options = [])
    {
        $selfId = static::getInputId($model, $attribute);
        $selfName = static::getInputName($model, $attribute);
        $options = array_merge([
            'field-id' => $selfId,
            'field-name' => $selfName,
            'schema' => $model->{$attribute}
        ], $options);
        return static::tag('blackcube-schema-editor', '', $options);
    }

    /**
     * @param Model $model
     * @param string $attribute
     * @param array $options
     * @return string
     * @throws InvalidConfigException
     */
    public static function activeUpload(Model $model, $attribute, $options = [])
    {
        if (isset($options['upload-url']) === false) {
            throw new InvalidConfigException();
        }
        $selfId = static::getInputId($model, $attribute);
        $selfName = static::getInputName($model, $attribute);

        $options = array_merge([
            'id' => $selfId,
            'name' => $selfName,
            'multiple' => false,
        ], $options);

        if (isset($options['value']) === false) {
            $options['value'] = static::getAttributeValue($model, $attribute);
        }

        return static::tag('blackcube-file', '', $options);
    }

    /**
     * @param array $structure
     * @param array $options
     * @return array
     */
    private static function filterElasticOptions($structure, $options = [])
    {
        if ($structure['field'] !== 'file' && $structure['field'] !== 'files') {
            unset($options['upload-url'], $options['preview-url'], $options['delete-url'], $options['file-type']);
        } elseif (($structure['field'] === 'file' || $structure['field'] === 'files')) {
            if (isset($structure['fileType']) && isset($options['file-type']) === false) {
                $options['file-type'] = $structure['fileType'];
            }
            if (isset($structure['imageWidth']) && isset($options['image-width']) === false) {
                $options['image-width'] = $structure['imageWidth'];
            }
            if (isset($structure['imageHeight']) && isset($options['image-height']) === false) {
                $options['image-height'] = $structure['imageHeight'];
            }
        }
        if ($structure['field'] === 'file') {
            $options['multiple'] = false;
        } elseif ($structure['field'] === 'files') {
            $options['multiple'] = true;
        }
        return $options;
    }

    /**
     * @param ElasticInterface $elastic
     * @param string $attribute
     * @param array $options
     * @return string
     */
    public static function activeElasticDescription(ElasticInterface $elastic, $attribute, $options = [])
    {
        if (!preg_match(static::$attributeRegex, $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }
        $realAttibute = $matches[2];
        $attributeHints = $elastic->attributeHints();
        if (isset($attributeHints[$realAttibute])) {
            return static::tag('span', $attributeHints[$realAttibute], $options);
        } else {
            return '';
        }
    }

    /**
     * @param ElasticInterface $elastic
     * @param string $attribute
     * @param array $options
     * @return string
     * @throws InvalidConfigException
     * @throws NotSupportedException
     */
    public static function activeElasticField(ElasticInterface $elastic, $attribute, $options = [])
    {
        if (!preg_match(static::$attributeRegex, $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }
        $realAttibute = $matches[2];
        $structure = $elastic->structure[$realAttibute];
        $options = static::filterElasticOptions($structure, $options);

        switch ($structure['field']) {
            //TODO: make better stuff using schemas properties min / max
            case 'file':
            case 'files':
                $options['class'] = ($elastic->hasErrors($realAttibute)?' error':'');
                $result = static::activeUpload($elastic, $attribute, $options);
                break;
            case 'dropdownlist':
                throw new NotSupportedException();
                break;
            case 'password':
                $result = static::activePasswordInput($elastic, $attribute, ['class' => 'textfield'.($elastic->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'checkbox':
                $result = static::activeCheckbox($elastic, $attribute, ['label' => false, 'class' => 'checkbox'.($elastic->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'checkboxlist':
                $mappedField = 'activeCheckboxList';
                throw new NotSupportedException();
                break;
            case 'radio':
                $result = static::activeRadio($elastic, $attribute, ['label' => false, 'class' => 'checkbox'.($elastic->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'radiolist':
                $mappedField = 'activeRadioList';
                throw new NotSupportedException();
                break;
            case 'textarea':
                $result = static::activeTextArea($elastic, $attribute, ['class' => 'textfield'.($elastic->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'text':
            default:
                $result = static::activeTextInput($elastic, $attribute, ['class' => 'textfield'.($elastic->hasErrors($realAttibute)?' error':'')]);
                break;
        }
        return $result;
    }

    /**
     * @param string $name
     * @param array $options
     * @return string
     */
    public static function svg($name, $options = [])
    {
        $tag = '';
        if (isset(static::$icons[$name])) {
            $options['viewBox'] = static::$icons[$name]['viewBox'];
            $options['xmlns'] = 'http://www.w3.org/2000/svg';
            $tag = static::tag('svg',
                static::tag('path', '', ['d' => static::$icons[$name]['path']]),
                $options
            );
        }
        return $tag;
    }
}
