<?php
/**
 * DeleteAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\node
 */
class DeleteAction extends Action
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

    /**
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $node = Node::findOne(['id' => $id]);
        if ($node === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            try {
                $slug = $node->getSlug()->one();
                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $node->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $node->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
