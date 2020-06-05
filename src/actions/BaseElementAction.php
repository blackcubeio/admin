<?php
/**
 * BaseAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */

namespace blackcube\admin\actions;

use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\db\ActiveQuery;
use Yii;

/**
 * Class BaseAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions
 */
abstract class BaseElementAction extends Action
{
    /**
     * @var callable
     */
    public $compositeQuery;

    /**
     * @var callable
     */
    public $compositesQuery;

    /**
     * @var callable
     */
    public $nodeQuery;

    /**
     * @var callable
     */
    public $nodesQuery;

    /**
     * @var callable
     */
    public $targetNodesQuery;

    /**
     * @var callable
     */
    public $typesQuery;

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getCompositeQuery()
    {
        $compositeQuery = null;
        if (is_callable($this->compositeQuery) === true) {
            $compositeQuery = call_user_func($this->compositeQuery);
        }
        if ($compositeQuery === null || (($compositeQuery instanceof ActiveQuery) === false)) {
            $compositeQuery = Composite::find();
        }
        return $compositeQuery;
    }

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getCompositesQuery()
    {
        $compositesQuery = null;
        if (is_callable($this->compositesQuery) === true) {
            $compositesQuery = call_user_func($this->compositesQuery);
        }
        if ($compositesQuery === null || (($compositesQuery instanceof ActiveQuery) === false)) {
            $compositesQuery = Composite::find();
        }
        return $compositesQuery;
    }

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getNodeQuery()
    {
        $nodeQuery = null;
        if (is_callable($this->nodeQuery) === true) {
            $nodeQuery = call_user_func($this->nodeQuery);
        }
        if ($nodeQuery === null || (($nodeQuery instanceof ActiveQuery) === false)) {
            $nodeQuery = Node::find();
        }
        return $nodeQuery;
    }

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getNodesQuery()
    {
        $nodesQuery = null;
        if (is_callable($this->nodesQuery) === true) {
            $nodesQuery = call_user_func($this->nodesQuery);
        }
        if ($nodesQuery === null || (($nodesQuery instanceof ActiveQuery) === false)) {
            $nodesQuery = Node::find();
        }
        return $nodesQuery;
    }

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getTargetNodesQuery()
    {
        $targetNodesQuery = null;
        if (is_callable($this->targetNodesQuery) === true) {
            $targetNodesQuery = call_user_func($this->targetNodesQuery);
        }
        if ($targetNodesQuery === null || (($targetNodesQuery instanceof ActiveQuery) === false)) {
            $targetNodesQuery = Node::find();
        }
        return $targetNodesQuery;
    }

    /**
     * @return \blackcube\core\models\FilterActiveQuery|mixed|ActiveQuery
     */
    public function getTypesQuery()
    {
        $typesQuery = null;
        if (is_callable($this->typesQuery) === true) {
            $typesQuery = call_user_func($this->typesQuery);
        }
        if ($typesQuery === null || (($typesQuery instanceof ActiveQuery) === false)) {
            $typesQuery = Type::find();
        }
        return $typesQuery;
    }

}
