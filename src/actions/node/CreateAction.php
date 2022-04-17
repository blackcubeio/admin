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
 * @package blackcube\admin\actions\node
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\MoveNodeForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
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
 * @package blackcube\admin\actions\node
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
        $node = Yii::createObject(Node::class);
        /* @var $node Node */

        if ($node === null) {
            throw new NotFoundHttpException();
        }
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $node);

        $moveNodeForm = Yii::createObject([
            'class' => MoveNodeForm::class,
            'move' => 1
        ]);

        $blocs = $node->getBlocs()->all();
        $compositesQuery = $node->getComposites();

        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            $moveNodeForm->load(Yii::$app->request->bodyParams);
            if ($moveNodeForm->move) {
                $targetNode = Node::findOne(['id' => $moveNodeForm->target]);
                $node->load(Yii::$app->request->bodyParams);
                switch ($moveNodeForm->mode) {
                    case 'into':
                        $node->saveInto($targetNode);
                        break;
                    case 'before':
                        $node->saveBefore($targetNode);
                        break;
                    case 'after':
                        $node->saveAfter($targetNode);
                        break;
                }
            }
            $result = NodeHelper::saveElement($node, $blocs);
            $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $node);
            $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($result === true && $validatePlugins === true) {

                $savePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_SAVE, $node);
                $savePlugins = array_reduce($savePlugins, function($accumulator, $item) {
                    return $accumulator && $item;
                }, true);
                if ($savePlugins === true) {
                    $transaction->commit();
                    return $this->controller->redirect([$this->targetAction, 'id' => $node->id]);
                }
            }
            $transaction->rollBack();
        }

        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);

        $targetNodesQuery = $this->getTargetNodesQuery()
            ->orderBy(['left' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);

        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'node' => $node,
            'typesQuery' => $typesQuery,
            'targetNodesQuery' => $targetNodesQuery,
            'blocs' => $blocs,
            'compositesQuery' => $compositesQuery,
            'languagesQuery' => $languagesQuery,
            'moveNodeForm' => $moveNodeForm,
        ]);
    }
}
