<?php
/**
 * RbacItemForm.php
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
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Model;
use Yii;

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
