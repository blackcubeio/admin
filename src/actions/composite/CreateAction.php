<?php
/**
 * CreateAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
 */

namespace blackcube\admin\actions\composite;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\NodeComposite;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\composite
 */
class CreateAction extends BaseElementAction
{
    /**
     * @var string view
     */
    public $view = 'form';

    /**
     * @var string where to redirect
     */
    public $targetAction = 'edit';

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        $composite = Yii::createObject(Composite::class);

        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $composite);

        $nodeComposite = Yii::createObject(NodeComposite::class);
        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            $composite->load(Yii::$app->request->bodyParams);
            $result = $composite->save();

            $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $composite);
            $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($result === true && $validatePlugins === true) {
                $nodeComposite->compositeId = $composite->id;
                CompositeHelper::handleNodes($composite, $nodeComposite);
                $savePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_SAVE, $composite);
                $savePlugins = array_reduce($savePlugins, function($accumulator, $item) {
                    return $accumulator && $item;
                }, true);
                if ($savePlugins === true) {
                    $transaction->commit();
                    return $this->controller->redirect([$this->targetAction, 'id' => $composite->id]);
                }
            }
            $transaction->rollBack();
        }

        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);

        $nodesQuery = $this->getNodesQuery()
            ->orderBy(['left' => SORT_ASC]);

        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'composite' => $composite,
            'typesQuery' => $typesQuery,
            'nodesQuery' => $nodesQuery,
            'nodeComposite' => $nodeComposite,
            'languagesQuery' => $languagesQuery,
        ]);

    }
}
