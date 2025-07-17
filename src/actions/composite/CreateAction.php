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

namespace blackcube\admin\actions\composite;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Composite as CompositeHelper;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\interfaces\SlugGeneratorInterface;
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\NodeComposite;
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
                ->andWhere(['compositeAllowed' => true]);
        }
        return $typesQuery;
    }

    /**
     * @param Composite $composite
     * @param NodeComposite $nodeComposite
     * @param Slug $slug
     * @param SlugGeneratorInterface $slugGenerator
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(Composite $composite, NodeComposite $nodeComposite, Slug $slug, SlugGeneratorInterface $slugGenerator, PluginsHandlerInterface $pluginsHandler)
    {

        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $composite);

        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->get('db')->beginTransaction();
            $composite->load(Yii::$app->request->bodyParams);
            $result = $composite->save();


            $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $composite);
            $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($result === true && $validatePlugins === true) {
                $nodeComposite->compositeId = $composite->id;
                CompositeHelper::handleNodes($composite, $nodeComposite);
                $slug->path = $slugGenerator->getElementSlug($composite);
                $slug->active = true;
                $result = $result && $slug->save();
                if ($result) {
                    $composite->attachSlug($slug);
                }
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
