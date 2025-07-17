<?php
/**
 * CreateAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\node;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Node as NodeHelper;
use blackcube\admin\models\MoveNodeForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\interfaces\SlugGeneratorInterface;
use blackcube\core\models\Language;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Type;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
     * {@inheritDoc}
     */
    public function getTypesQuery()
    {
        $typesQuery = null;
        if (is_callable($this->typesQuery) === true) {
            $typesQuery = call_user_func($this->typesQuery);
        }
        if ($typesQuery === null || (($typesQuery instanceof ActiveQuery) === false)) {
            $typesQuery = Type::find()
            ->andWhere(['nodeAllowed' => true]);
        }
        return $typesQuery;
    }

    /**
     * @param Node $node
     * @param MoveNodeForm $moveNodeForm
     * @param Slug $slug
     * @param SlugGeneratorInterface $slugGenerator
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Node $node, MoveNodeForm $moveNodeForm, Slug $slug, SlugGeneratorInterface $slugGenerator, PluginsHandlerInterface $pluginsHandler)
    {

        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $node);

        $moveNodeForm->move = 1;

        $blocs = $node->getBlocs()->all();
        $compositesQuery = $node->getComposites();

        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->get('db')->beginTransaction();
            $moveNodeForm->load(Yii::$app->request->bodyParams);
            $node->load(Yii::$app->request->bodyParams);
            $validateNode = $node->validate();
            $validateNodeMove = $moveNodeForm->validate();
            if ($moveNodeForm->move && $validateNodeMove === true && $validateNode === true) {
                $targetNode = Node::findOne(['id' => $moveNodeForm->target]);
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
            if ($validateNodeMove === true && $validateNode) {
                $result = NodeHelper::saveElement($node, $blocs);
                $slug->path = $slugGenerator->getElementSlug($node);
                $slug->active = true;
                $result = $result && $slug->save();
                if ($result) {
                    $node->attachSlug($slug);
                }
                $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $node);
                $validatePlugins = array_reduce($validatePlugins, function ($accumulator, $item) {
                    return $accumulator && $item;
                }, true);
            } else {
                $result = false;
                $validatePlugins = false;
            }
            if ($validateNodeMove === true && $validateNode && $result === true && $validatePlugins === true) {

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
