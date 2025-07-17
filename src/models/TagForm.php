<?php
/**
 * TagForm.php
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
 * TagForm Model
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class TagForm extends Model
{

    /**
     * @var number
     */
    public $id;

    public $name;

    public $checked;


    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['id'], 'number'],
            [['name'], 'string'],
            [['checked'], 'boolean'],
        ];
    }

}
