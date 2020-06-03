<?php
/**
 * Composite.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\interfaces\TaggableInterface;
use blackcube\core\models\NodeComposite;
use Yii;

/**
 * Class CompositeHelper
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\helpers
 */

class Composite extends Element {
    /**
     * Handle composite / node (re)attach
     * @param $composite Composite
     * @param $nodeComposite NodeComposite
     * @return bool
     */
    public static function handleNodes($composite, $nodeComposite)
    {
        $status = true;
        if (Yii::$app->request->isPost) {
            try {
                $transaction = Module::getInstance()->db->beginTransaction();
                $currentAttachedNode = $nodeComposite->node;
                $nodeComposite->load(Yii::$app->request->bodyParams);
                $newAttachedNode = $nodeComposite->node;
                if (($currentAttachedNode !== null) && ($newAttachedNode === null)) {
                    $currentAttachedNode->detachComposite($composite);
                } elseif (($currentAttachedNode !== null) && ($newAttachedNode !== null)) {
                    if ($currentAttachedNode->id !== $newAttachedNode->id) {
                        $currentAttachedNode->detachComposite($composite);
                        $newAttachedNode->attachComposite($composite);
                    }
                } elseif (($currentAttachedNode === null) && ($newAttachedNode !== null)) {
                    $newAttachedNode->attachComposite($composite);
                }
                $nodeComposite = NodeComposite::find()
                    ->andWhere(['compositeId' => $composite->id])
                    ->orderBy(['order' => SORT_ASC])
                    ->one();
                if ($nodeComposite === null) {
                    $nodeComposite = Yii::createObject(NodeComposite::class);
                    $nodeComposite->compositeId = $composite->id;
                }
                $transaction->commit();
            } catch(\Exception $e) {
                $status = false;
                $transaction->rollBack();
            }
        }
        return $status;
    }
}
