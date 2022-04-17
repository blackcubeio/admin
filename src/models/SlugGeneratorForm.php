<?php
/**
 * SlugGeneratorForm.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Node;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Model;
use Yii;

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
