<?php
/**
 * DeleteAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\category
 */

namespace blackcube\admin\actions\category;

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
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\category
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
        $category = $this->getCategoryQuery()
            ->andWhere(['id' => $id])
            ->one();

        if ($category === null) {
            throw new NotFoundHttpException();
        }
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->get('db')->beginTransaction();

            try {
                $slug = $category->getSlug()->one();
                $deletePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_DELETE, $category);
                $deletePlugins = array_reduce($deletePlugins, function($accumulator, $item) {
                    return $accumulator && $item;
                }, true);

                if ($slug !== null) {
                    $slug->delete();
                }
                $blocsQuery = $category->getBlocs();
                foreach($blocsQuery->each() as $bloc) {
                    $bloc->delete();
                }
                $tagsQuery = $category->getTags()->with('blocs');
                foreach($tagsQuery->each() as $tag) {
                    foreach($tag->blocs as $bloc) {
                        $bloc->delete();
                    }
                    $tag->delete();
                }
                $category->delete();
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
            }
        }
        return $this->controller->redirect([$this->targetAction]);
    }
}
