<?php
/**
 * MoveNodeForm.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\models;

use blackcube\admin\Module;
use blackcube\core\models\Node;
use yii\base\Model;

/**
 * MoveNodeForm Model
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
            [['mode', 'target'], 'required', 'when' => function($model) {
                return $model->move == 1;
            }],
            [['target'], 'exist', 'targetAttribute' => 'id', 'targetClass' => Node::class],
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
