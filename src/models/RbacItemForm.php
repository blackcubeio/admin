<?php
/**
 * RbacItemForm.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use yii\base\Model;

/**
 * RbacItemForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
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
