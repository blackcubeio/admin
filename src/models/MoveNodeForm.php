<?php
/**
 * MoveNodeForm.php
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

use blackcube\admin\Module;
use yii\base\Model;

/**
 * MoveNodeForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */
class MoveNodeForm extends Model
{

    /**
     * @var number
     */
    public $move;

    public $mode;

    public $target;


    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['move', 'target'], 'number'],
            [['mode'], 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'move' => Module::t('node', 'Move Node'),
            'mode' => Module::t('node', 'Mode'),
            'target' => Module::t('node', 'Target node')
        ];
    }

}
