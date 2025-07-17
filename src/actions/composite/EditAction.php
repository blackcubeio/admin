<?php
/**
 * EditAction.php
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
use blackcube\core\models\Composite;
use blackcube\core\models\Language;
use blackcube\core\models\NodeComposite;
use blackcube\core\models\Type;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class EditAction extends BaseElementAction
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
            ->with('blocs.blocType')
            ->one();
        /* @var $composite Composite */

        if ($composite === null) {
            throw new NotFoundHttpException();
        }
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $composite);

        $blocs = $composite->blocs; // getBlocs()->all();
        $nodeComposite = NodeComposite::find()
            ->andWhere(['compositeId' => $composite->id])
            ->orderBy(['order' => SORT_ASC])
            ->one();
        if ($nodeComposite === null) {
            $nodeComposite = Yii::createObject(NodeComposite::class);
            $nodeComposite->compositeId = $composite->id;
        }

        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->get('db')->beginTransaction();
            $result = CompositeHelper::saveElement($composite, $blocs);
            $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $composite);
            $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($result === true && $validatePlugins === true) {
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
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }
}
