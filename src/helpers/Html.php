<?php

namespace blackcube\admin\helpers;

use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use blackcube\core\models\Bloc;
use blackcube\core\interfaces\ElasticInterface;
use yii\base\NotSupportedException;

class Html extends \yii\helpers\Html
{
    private static $icons = [
        'plus' => [
            'path' => 'M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z',
            'viewBox' => '0 0 20 20',
        ],
    ];

    public static function activeDateTimeInput($model, $attribute, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        if (isset($options['value'])) {
            $value = $options['value'];
        } else {
            $currentValue = static::getAttributeValue($model, $attribute);
            if ($currentValue instanceof \DateTime) {
                $value = $currentValue->format('Y-m-d\TH:i:s');
            } else {
                $value = $currentValue;
            }
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        static::setActivePlaceholder($model, $attribute, $options);
        // self::normalizeMaxLength($model, $attribute, $options);

        return static::input('datetime-local', $name, $value, $options);
    }

    public static function activeDateInput($model, $attribute, $options = [])
    {
        $name = isset($options['name']) ? $options['name'] : static::getInputName($model, $attribute);
        if (isset($options['value'])) {
            $value = $options['value'];
        } else {
            $currentValue = static::getAttributeValue($model, $attribute);
            if ($currentValue instanceof \DateTime) {
                $value = $currentValue->format('Y-m-d');
            } else {
                $value = $currentValue;
            }
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = static::getInputId($model, $attribute);
        }

        static::setActivePlaceholder($model, $attribute, $options);
        // self::normalizeMaxLength($model, $attribute, $options);

        return static::input('date', $name, $value, $options);
    }

    public static function activeSchema(Model $model, $attribute, $options = [])
    {
        $selfId = static::getInputId($model, $attribute);
        $selfName = static::getInputName($model, $attribute);
        $options = array_merge([
            'field-id' => $selfId,
            'field-name' => $selfName,
            'schema' => $model->{$attribute}
        ], $options);
        $tag = static::tag('blackcube-schema-editor', '', $options);
        return $tag;
    }

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

    private static function filterElasticOptions($structure, $options = [])
    {
        if ($structure['field'] !== 'file' && $structure['field'] !== 'files') {
            unset($options['upload-url'], $options['preview-url'], $options['delete-url'], $options['file-type']);
        } elseif (($structure['field'] === 'file' || $structure['field'] === 'files') && isset($structure['fileType']) && isset($options['file-type']) === false) {
            $options['file-type'] = $structure['fileType'];
        }
        if ($structure['field'] === 'file') {
            $options['multiple'] = false;
        } elseif ($structure['field'] === 'files') {
            $options['multiple'] = true;
        }
        return $options;
    }

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
