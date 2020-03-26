<?php

namespace blackcube\admin\helpers;

use yii\base\Model;

class Bloc
{
    public static function mapField($field = null) {
        switch ($field) {
            case 'dropdownlist':
                $mappedField = 'activeDropDownList';
                break;
            case 'password':
                $mappedField = 'activePasswordInput';
                break;
            case 'checkbox':
                $mappedField = 'activeCheckbox';
                break;
            case 'checkboxlist':
                $mappedField = 'activeCheckboxList';
                break;
            case 'radio':
                $mappedField = 'activeRadio';
                break;
            case 'radiolist':
                $mappedField = 'activeRadioList';
                break;
            case 'textarea':
                $mappedField = 'activeTextarea';
                break;
            case 'text':
            default:
                $mappedField = 'activeTextInput';
                break;
        }
        return $mappedField;
    }
}
