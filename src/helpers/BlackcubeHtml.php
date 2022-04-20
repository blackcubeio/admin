<?php
/**
 * BlackcubeHtml.php
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

use blackcube\admin\Module;
use blackcube\core\interfaces\ElasticInterface;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\validators\StringValidator;


/**
 * Class BlackcubeHtml
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */
class BlackcubeHtml
{
    public static $inputTemplate = <<< EOT
<div class="element-form-bloc-textfield-wrapper">
    {label}
    <div class="element-form-bloc-textfield-input-wrapper">
        {field}
    </div>
    <p class="element-form-bloc-abstract">
        {hint}
    </p>
</div>
EOT;
    public static $radioListTemplate = <<< EOT
<div>
    {label}
    {radios}
</div>
EOT;
    public static $booleanTemplate = <<< EOT
<div class="mt-2">
    {mainLabel}
    <div class="element-form-bloc-{type}-wrapper">
        <div class="element-form-bloc-{type}-input-wrapper">
            {hidden}
            {field}
        </div>        
        <div class="element-form-bloc-{type}-label-wrapper">
            {label}
            <p class="element-form-bloc-abstract">
                {hint}
            </p>
        </div>
    </div>
</div>
EOT;
    public static $schemaTemplate = <<< EOT
<div class="element-form-bloc-schema-wrapper">
    {label}
    {editor}
    <p class="element-form-bloc-abstract">
        {hint}
    </p>
</div>
EOT;
    public static $dropdownListTemplate = <<< EOT
<div class="element-form-bloc-select-wrapper">
    {label}
    {dropdown}
    <p class="element-form-bloc-abstract">
        {hint}
    </p>
</div>
EOT;
    public static function activeEditor(Model $model, $attribute, $options = [])
    {
        $selfId = Html::getInputId($model, $attribute);
        $selfName = Html::getInputName($model, $attribute);
        $attributeName = Html::getAttributeName($attribute);
        $error = $model->hasErrors($attributeName);
        $errorClass = ArrayHelper::remove($options, 'errorClass', 'error');
        $errorClass = $error ? ' '.$errorClass : '';
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);

        $labelContent = ArrayHelper::remove($options, 'label', $model->getAttributeLabel($modelAttribute));
        $hint = ArrayHelper::remove($options, 'hint', $model->getAttributeHint($modelAttribute));

        $options = array_merge([
            'field-id' => $selfId,
            'field-name' => $selfName,
            'content.bind' => $model->{$attributeName},
        ], $options);

        $labelOptions['class'] = 'element-form-bloc-label'.$errorClass;
        
        return str_replace([
            '{label}',
            '{editor}',
            '{hint}'
        ], [
            Html::label($labelContent, $selfId, $labelOptions),
            Aurelia::component('blackcube-quill-editor', '', $options),
            $hint
        ], static::$schemaTemplate);
    }

    public static function activeSchema(Model $model, $attribute, $options = [])
    {
        $selfId = Html::getInputId($model, $attribute);
        $selfName = Html::getInputName($model, $attribute);
        $attributeName = Html::getAttributeName($attribute);
        $error = $model->hasErrors($attributeName);
        $errorClass = ArrayHelper::remove($options, 'errorClass', 'error');
        $errorClass = $error ? ' '.$errorClass : '';
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);

        $labelContent = ArrayHelper::remove($options, 'label', $model->getAttributeLabel($modelAttribute));
        $labelOptions['class'] = 'element-form-bloc-label'.$errorClass;
        $hint = ArrayHelper::remove($options, 'hint', $model->getAttributeHint($modelAttribute));

        $options = array_merge([
            'field-id' => $selfId,
            'field-name' => $selfName,
            'schema' => $model->{$attribute}
        ], $options);

        return str_replace([
            '{label}',
            '{editor}',
            '{hint}'
        ], [
            Html::label($labelContent, $selfId, $labelOptions),
            Aurelia::component('blackcube-schema-editor', '', $options),
            $hint
        ], static::$schemaTemplate);
    }

    public static function dropDownList($name, $selection = null, $items = [], $options = [])
    {
        $for = $options['id'] ?? Html::getInputIdByName($name);
        $error = ArrayHelper::remove($options, 'error', false);
        $errorClass = ArrayHelper::remove($options, 'errorClass', 'error');
        $errorClass = $error ? ' '.$errorClass : '';
        $labelContent = ArrayHelper::remove($options, 'label', $name);
        $labelOptions = ArrayHelper::remove($options, 'labelOptions', []);
        $labelOptions['class'] = 'element-form-bloc-label'.$errorClass;
        $hint = ArrayHelper::remove($options, 'hint', null);
        $options['class'] = 'element-form-bloc-select'.$errorClass;

        return str_replace([
            '{label}',
            '{dropdown}',
            '{hint}'
        ], [
            Html::label($labelContent, $for, $labelOptions),
            Html::dropDownList($name, $selection, $items, $options),
            $hint
        ], static::$dropdownListTemplate);
    }

    public static function activeDropDownList($model, $attribute, $items, $options = [])
    {
        $attributeName = Html::getAttributeName($attribute);
        $name = $options['name'] ?? Html::getInputName($model, $attribute);
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);
        $options['error'] = $model->hasErrors($modelAttribute);
        $selection = ArrayHelper::remove($options, 'value', Html::getAttributeValue($model, $attribute));
        if(isset($options['label']) === false) {
            $options['label'] = Html::encode($model->getAttributeLabel($modelAttribute));
        }
        if(isset($options['hint']) === false) {
            $options['hint'] = Html::encode($model->getAttributeHint($modelAttribute));
        }
        return static::dropDownList($name, $selection, $items, $options);
    }

    protected static function setActivePlaceholder($model, $attribute, &$options = [])
    {
        if (isset($options['placeholder']) && $options['placeholder'] === true) {
            $attribute = Html::getAttributeName($attribute);
            $options['placeholder'] = $model->getAttributeLabel($attribute);
        }
    }

    private static function normalizeMaxLength($model, $attribute, &$options)
    {
        if (isset($options['maxlength']) && $options['maxlength'] === true) {
            unset($options['maxlength']);
            $attrName = Html::getAttributeName($attribute);
            foreach ($model->getActiveValidators($attrName) as $validator) {
                if ($validator instanceof StringValidator && ($validator->max !== null || $validator->length !== null)) {
                    $options['maxlength'] = max($validator->max, $validator->length);
                    break;
                }
            }
        }
    }

    public static function activeTextarea($model, $attribute, $options = [])
    {
        return static::activeInput('textarea', $model, $attribute, $options);
    }
    public static function activeTextInput($model, $attribute, $options = [])
    {
        return static::activeInput('text', $model, $attribute, $options);
    }
    public static function activePasswordInput($model, $attribute, $options = [])
    {
        return static::activeInput('password', $model, $attribute, $options);
    }
    public static function activeDateInput($model, $attribute, $options = [])
    {
        return static::activeInput('date', $model, $attribute, $options);
    }
    public static function activeDateTimeInput($model, $attribute, $options = [])
    {
        return static::activeInput('datetime-local', $model, $attribute, $options);
    }
    public static function activeInput($type, Model $model, $attribute, $options = [])
    {
        $attributeName = Html::getAttributeName($attribute);
        $name = $options['name'] ?? Html::getInputName($model, $attribute);
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);
        $options['error'] = $model->hasErrors($modelAttribute);
        if(isset($options['label']) === false) {
            $options['label'] = Html::encode($model->getAttributeLabel($modelAttribute));
        }
        if(isset($options['hint']) === false) {
            $options['hint'] = Html::encode($model->getAttributeHint($modelAttribute));
        }

        if($type === 'date' || $type === 'datetime-local') {
            $format = ($type === 'date') ? 'Y-m-d' : 'Y-m-d\TH:i:s';
            if (isset($options['value'])) {
                $value = $options['value'];
            } else {
                $currentValue = Html::getAttributeValue($model, $attribute);
                if ($currentValue instanceof \DateTime) {
                    $value = $currentValue->format($format);
                } elseif ($currentValue !== null) {
                    $currentDate = new \DateTime($currentValue);
                    $value = $currentDate->format($format);
                } else {
                    $value = null;
                }
            }
        } else {
            $value = $options['value'] ?? Html::getAttributeValue($model, $attribute);
        }


        if (!array_key_exists('id', $options)) {
            $options['id'] = Html::getInputId($model, $attribute);
        }
        self::setActivePlaceholder($model, $attribute, $options);
        self::normalizeMaxLength($model, $attribute, $options);

        return static::input($type, $name, $value, $options);
    }

    public static function input($type, $name, $value = null, $options = []) {
        $for = $options['id'] ?? Html::getInputIdByName($name);
        $error = ArrayHelper::remove($options, 'error', false);
        $errorClass = ArrayHelper::remove($options, 'errorClass', 'error');
        $errorClass = $error ? ' '.$errorClass : '';
        $labelContent = ArrayHelper::remove($options, 'label', $name);
        $labelOptions = ArrayHelper::remove($options, 'labelOptions', []);
        $labelOptions['class'] = 'element-form-bloc-label'.$errorClass;
        $hint = ArrayHelper::remove($options, 'hint', null);
        $options['class'] = 'element-form-bloc-textfield'.$errorClass;

        if($type === 'textarea') {
            $doubleEncode = ArrayHelper::remove($options, 'doubleEncode', true);
            $field = Html::textarea($name, Html::encode($value, $doubleEncode), $options);
        } else {
            $field = Html::input($type, $name, $value, $options);;
        }
        return str_replace([
            '{label}',
            '{field}',
            '{hint}'
        ], [
            Html::label($labelContent, $for, $labelOptions),
            $field,
            $hint
        ], static::$inputTemplate);
    }

    public static function activeCheckbox($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('checkbox', $model, $attribute, $options);
    }

    public static function checkbox($name, $checked = false, $options = [])
    {
        return static::booleanInput('checkbox', $name, $checked, $options);
    }

    public static function activeRadio($model, $attribute, $options = [])
    {
        return static::activeBooleanInput('radio', $model, $attribute, $options);
    }

    public static function activeRadioList($model, $attribute, $items, $options = []) {
        $targetId = $options['id'] ?? Html::getInputId($model, $attribute);
        $attributeName = Html::getAttributeName($attribute);
        $name = $options['name'] ?? Html::getInputName($model, $attribute);
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);
        $itemsDetail = ArrayHelper::remove($options, 'items', null);
        $hint = ArrayHelper::remove($options, 'hint', null);
        $count = 0;
        $boxes = '';
        foreach($items as $id => $title) {
            $radioOptions = [
                'id' => $targetId .'-'.$count,
                'label' => $title,
                'value' => $id,
                'uncheck' => null,
            ];
            if (isset($itemsDetail[$id]['description'])) {
                $radioOptions['hint'] = $itemsDetail[$id]['description'];
            }
            $boxes .= static::activeRadio($model, $attribute, $radioOptions);
            $count++;
        }

        return str_replace([
            '{label}',
            '{radios}',
            '{hint}'
        ], [
            Html::label(Html::encode($model->getAttributeLabel($modelAttribute)), null, ['class' => 'element-form-bloc-label']),
            $boxes,
            $hint
        ], static::$radioListTemplate);
    }

    protected static function activeBooleanInput($type, Model $model, $attribute, $options = [])
    {
        $attributeName = Html::getAttributeName($attribute);
        $name = $options['name'] ?? Html::getInputName($model, $attribute);
        $modelAttribute = ArrayHelper::remove($options,'realAttribute', $attributeName);
        $options['error'] = $model->hasErrors($modelAttribute);
        if(isset($options['label']) === false) {
            $options['label'] = Html::encode($model->getAttributeLabel($modelAttribute));
        }
        if(isset($options['hint']) === false) {
            $options['hint'] = Html::encode($model->getAttributeHint($modelAttribute));
        }
        if (!array_key_exists('id', $options)) {
            $options['id'] = Html::getInputId($model, $attribute);
        }
        $value = Html::getAttributeValue($model, $attribute);

        if (!array_key_exists('value', $options)) {
            $options['value'] = '1';
        }
        if (!array_key_exists('uncheck', $options)) {
            $options['uncheck'] = '0';
        } elseif ($options['uncheck'] === false) {
            unset($options['uncheck']);
        }
        $checked = "$value" === "{$options['value']}";
        return static::booleanInput($type, $name, $checked, $options);
    }
    protected static function booleanInput($type, $name, $checked = false, $options = []) {
        $for = $options['id'] ?? Html::getInputIdByName($name);
        $error = ArrayHelper::remove($options, 'error', false);
        $errorClass = ArrayHelper::remove($options, 'errorClass', 'error');
        $errorClass = $error ? ' '.$errorClass : '';
        $labelContent = ArrayHelper::remove($options, 'label', $name);
        $labelOptions = ArrayHelper::remove($options, 'labelOptions', []);
        $hint = ArrayHelper::remove($options, 'hint', null);
        $mainLabelContent = ArrayHelper::remove($options, 'mainLabel', '');
        $mainLabelOptions = ArrayHelper::remove($options, 'mainLabelOptions', ['class' => 'element-form-bloc-label']);

        if (!isset($options['checked'])) {
            $options['checked'] = (bool) $checked;
        }
        $value = array_key_exists('value', $options) ? $options['value'] : '1';
        if (isset($options['uncheck'])) {
            // add a hidden field so that if the checkbox is not selected, it still submits a value
            $hiddenOptions = [];
            if (isset($options['form'])) {
                $hiddenOptions['form'] = $options['form'];
            }
            // make sure disabled input is not sending any value
            if (!empty($options['disabled'])) {
                $hiddenOptions['disabled'] = $options['disabled'];
            }
            $hidden = Html::hiddenInput($name, $options['uncheck'], $hiddenOptions);
            unset($options['uncheck']);
        } else {
            $hidden = '';
        }
        $options['class'] = 'element-form-bloc-'.$type.$errorClass;
        $options['label'] = null;

        return str_replace([
            '{type}',
            '{hidden}',
            '{mainLabel}',
            '{label}',
            '{field}',
            '{hint}'
        ], [
            $type,
            $hidden,
            empty($mainLabelContent) ? '' : Html::label($mainLabelContent, null, $mainLabelOptions),
            Html::label($labelContent, $for, $labelOptions),
            Html::input($type, $name, $value, $options),
            $hint
        ], static::$booleanTemplate);
    }

    public static function activeUpload(Model $model, $attribute, $options = [])
    {
        if (isset($options['upload-url']) === false) {
            throw new InvalidConfigException();
        }
        $cleanAttribute = Html::getAttributeName($attribute);
        $realAttribute = $options['realAttribute'] ?? $cleanAttribute;
        $hasError = $model->hasErrors($realAttribute);
        unset($options['errorClass'], $options['hint'], $options['realAttribute']);

        $selfId = Html::getInputId($model, $attribute);
        $selfName = Html::getInputName($model, $attribute);

        $options = array_merge([
            'id' => $selfId,
            'name' => $selfName,
            'multiple.bind' => false,
            'error.bind' => $hasError,
        ], $options);
        $uploadText = $options['multiple.bind'] ? Module::t('widgets', 'Upload files') : Module::t('widgets', 'Upload A file');

        $options['title'] = Html::encode($model->getAttributeLabel($cleanAttribute));
        $options['upload-file-text'] = $uploadText;
        $options['upload-file-dnd'] = Module::t('widgets', 'or drag and drop');

        if (isset($options['value']) === false) {
            $options['value'] = Html::getAttributeValue($model, $attribute);
        }

        return Aurelia::component('blackcube-file-upload', '', $options);
    }

    public static function activeElasticField(ElasticInterface $elastic, $attribute, $options = [])
    {
        $realAttibute = Html::getAttributeName($attribute);
        $structure = $elastic->structure[$realAttibute];
        $options = static::filterElasticOptions($structure, $options);
        $options['hint'] = $elastic->attributeHints[$realAttibute] ?? null;
        switch ($structure['field']) {
            //TODO: make better stuff using schemas properties min / max
            case 'file':
            case 'files':
                $result = static::activeUpload($elastic, $attribute, $options);
                break;
            case 'email':
            case 'number':
            case 'date':
            case 'datetime-local':
                $result = static::activeInput($structure['field'], $elastic, $attribute, $options);
                break;
            case 'wysiwyg':
                $result = static::activeEditor($elastic, $attribute, $options);
                break;
            case 'dropdownlist':
                $result = static::activeDropDownList($elastic, $attribute, ArrayHelper::map($structure['items'], 'value', 'title'), $options);
                break;
            case 'password':
                $result = static::activePasswordInput($elastic, $attribute, $options);
                break;
            case 'checkbox':
                $result = static::activeCheckbox($elastic, $attribute, $options);
                break;
            case 'checkboxList':
                $mappedField = 'activeCheckboxList';
                throw new NotSupportedException();
                break;
            case 'radio':
                $result = static::activeRadio($elastic, $attribute, $options);
                break;
            case 'radioList':
            case 'radiolist':
                $options['items'] = ArrayHelper::index($structure['items'], 'value');
                $result = static::activeRadioList($elastic, $attribute, ArrayHelper::map($structure['items'], 'value', 'title'), $options);
                // throw new NotSupportedException();
                break;
            case 'textarea':
                $result = static::activeTextArea($elastic, $attribute, $options);
                break;
            case 'text':
            default:
                $result = static::activeTextInput($elastic, $attribute, $options);
                break;
        }
        return $result;
    }

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
            $options['multiple.bind'] = false;
        } elseif ($structure['field'] === 'files') {
            $options['multiple.bind'] = true;
        }
        return $options;
    }
}