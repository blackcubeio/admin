<?php
/**
 * TagForm.php
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

use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Model;
use Yii;

/**
 * TagForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
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
