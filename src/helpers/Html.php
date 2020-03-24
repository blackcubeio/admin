<?php

namespace blackcube\admin\helpers;

use yii\base\Model;

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
