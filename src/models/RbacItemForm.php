<?php
/**
 * RbacItemForm.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\models;

use yii\base\Model;

/**
 * RbacItemForm Model
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class RbacItemForm extends Model
{

    public $type;

    public $name;

    public $checked;

    public $disabled;

    public $label;


    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['type', 'name', 'label'], 'string'],
            [['checked', 'disabled'], 'boolean'],
        ];
    }

}
