<?php

namespace blackcube\admin\helpers;

use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use blackcube\core\models\Bloc;
use yii\base\NotSupportedException;

class Html extends \yii\helpers\Html
{
    private static $icons = [
        'plus' => [
            'path' => 'M11 9h4v2h-4v4H9v-4H5V9h4V5h2v4zm-1 11a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16z',
            'viewBox' => '0 0 20 20',
        ],
    ];

    public static function activeSchema(Model $model, $attribute, $options = [])
    {
        $selfId = static::getInputId($model, $attribute);
        $selfName = static::getInputName($model, $attribute);
        $options = array_merge([
            'field-id' => $selfId,
            'field-name' => $selfName,
            'schema' => $model->{$attribute}
        ], $options);
        $tag = static::tag('schema-editor', '', $options);
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

        return static::tag('resumable-file', '', $options);
    }

    public static function activeElasticField(Bloc $bloc, $attribute, $options = [])
    {
        if (!preg_match(static::$attributeRegex, $attribute, $matches)) {
            throw new InvalidArgumentException('Attribute name must contain word characters only.');
        }
        $realAttibute = $matches[2];
        if (isset($options['upload-url']) === true) {
            $uploadUrl = $options['upload-url'];
            unset($options['upload-url']);
        } else {
            $uploadUrl = null;
        }
        if (isset($options['preview-url']) === true) {
            $previewUrl = $options['preview-url'];
            unset($options['preview-url']);
        } else {
            $previewUrl = null;
        }
        if (isset($options['delete-url']) === true) {
            $deleteUrl = $options['delete-url'];
            unset($options['delete-url']);
        } else {
            $deleteUrl = null;
        }
        $structure = $bloc->structure[$realAttibute];
        switch ($structure['field']) {
            case 'file':
                $finalOptions = $options;
                if ($uploadUrl !== null) {
                    $finalOptions['upload-url'] = $uploadUrl;
                }
                if ($previewUrl !== null) {
                    $finalOptions['preview-url'] = $previewUrl;
                }
                if ($deleteUrl !== null) {
                    $finalOptions['delete-url'] = $deleteUrl;
                }
                $finalOptions['multiple'] = false;
                $finalOptions['class'] = ($bloc->hasErrors($realAttibute)?' error':'');
                $result = static::activeUpload($bloc, $attribute, $finalOptions);
                break;
            case 'files':
                $finalOptions = $options;
                if ($uploadUrl !== null) {
                    $finalOptions['upload-url'] = $uploadUrl;
                }
                if ($previewUrl !== null) {
                    $finalOptions['preview-url'] = $previewUrl;
                }
                if ($deleteUrl !== null) {
                    $finalOptions['delete-url'] = $deleteUrl;
                }
                $finalOptions['multiple'] = true;
                if (isset($options['value'])) {
                    $finalOptions['value'] = $options['value'];
                } else {
                    $finalOptions['value'] = static::getAttributeValue($bloc, $attribute);
                }
                $finalOptions['class'] = ($bloc->hasErrors($realAttibute)?' error':'');

                $result = static::activeUpload($bloc, $attribute, $finalOptions);
                break;
            case 'dropdownlist':
                throw new NotSupportedException();
                break;
            case 'password':
                $result = static::activePasswordInput($bloc, $attribute, ['class' => 'textfield'.($bloc->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'checkbox':
                $result = static::activeCheckbox($bloc, $attribute, ['label' => false, 'class' => 'checkbox'.($bloc->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'checkboxlist':
                $mappedField = 'activeCheckboxList';
                throw new NotSupportedException();
                break;
            case 'radio':
                $result = static::activeRadio($bloc, $attribute, ['label' => false, 'class' => 'checkbox'.($bloc->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'radiolist':
                $mappedField = 'activeRadioList';
                throw new NotSupportedException();
                break;
            case 'textarea':
                $result = static::activeTextArea($bloc, $attribute, ['class' => 'textfield'.($bloc->hasErrors($realAttibute)?' error':'')]);
                break;
            case 'text':
            default:
                $result = static::activeTextInput($bloc, $attribute, ['class' => 'textfield'.($bloc->hasErrors($realAttibute)?' error':'')]);
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
