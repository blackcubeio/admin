<?php
/**
 * SlugGeneratorForm.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\models;

use blackcube\core\models\Category;
use blackcube\core\models\Node;
use yii\base\Model;

/**
 * SlugGeneratorForm Model
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class SlugGeneratorForm extends Model
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $parentElementType;

    /**
     * @var int
     */
    public $parentElementId;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['parentElementId'], 'filter', 'filter' => function($value) {
                return ($value > 0) ? (int)$value : null;
            }],
            [['parentElementType'], 'in', 'range' => [Category::getElementType(), Node::getElementType()]],
            [['name'], 'string', 'max' => 255],
            [['name'], 'required'],
        ];
    }
}
