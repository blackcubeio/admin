<?php
/**
 * SlugGeneratorForm.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use blackcube\core\models\Category;
use blackcube\core\models\Node;
use yii\base\Model;

/**
 * SlugGeneratorForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
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
