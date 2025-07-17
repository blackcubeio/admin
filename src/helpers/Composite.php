<?php
/**
 * Composite.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use blackcube\admin\Module;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Composite as CompositeModel;
use Yii;

/**
 * Class CompositeHelper
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

class Composite extends Element {
    /**
     * Handle composite / node (re)attach
     * @param $composite CompositeModel
     * @param $nodeComposite NodeComposite
     * @return bool
     */
    public static function handleNodes($composite, $nodeComposite)
    {
        $status = true;
        if (Yii::$app->request->isPost) {
            try {
                $transaction = Module::getInstance()->get('db')->beginTransaction();
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
