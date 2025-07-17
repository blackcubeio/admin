<?php
/**
 * DeleteAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class DeleteAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class DeleteAction extends BaseElementAction
{
    /**
     * @var string where to redirect
     */
    public $targetAction = 'index';

    /**
     * @param string $id
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id, PluginsHandlerInterface $pluginsHandler)
    {
        $composite = $this->getCompositeQuery()
            ->andWhere(['id' => $id])
            ->one();

        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->get('db')->beginTransaction();

            try {
                $slug = $composite->getSlug()->one();
                $nodes = $composite->getNodes()->all();
                foreach ($nodes as $node) {
                    /* @var $node \blackcube\core\models\Node */
                    $node->detachComposite($composite);
                }
                $deletePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_DELETE, $composite);
                $deletePlugins = array_reduce($deletePlugins, function($accumulator, $item) {
                    return $accumulator && $item;
                }, true);

                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $composite->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }

                $composite->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
