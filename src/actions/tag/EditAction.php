<?php
/**
 * EditAction.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\tag
 */

namespace blackcube\admin\actions\tag;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Tag as TagHelper;
use blackcube\admin\models\SlugForm;
use blackcube\admin\Module;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Tag;
use blackcube\core\models\Language;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class EditAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\category
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
     * @param string $id
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run($id)
    {
        $tag = $this->getTagsQuery()
            ->andWhere(['id' => $id])
            ->with('blocs.blocType')
            ->one();
        /* @var $tag Tag */

        if ($tag === null) {
            throw new NotFoundHttpException();
        }
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $tag);

        $blocs = $tag->blocs; // getBlocs()->all();

        if (Yii::$app->request->isPost) {
            $transaction = Module::getInstance()->db->beginTransaction();
            $result = TagHelper::saveElement($tag, $blocs);
            $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $tag);
            $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($result === true && $validatePlugins === true) {
                $savePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_SAVE, $tag);
                $savePlugins = array_reduce($savePlugins, function($accumulator, $item) {
                    return $accumulator && $item;
                }, true);
                if ($savePlugins === true) {
                    $transaction->commit();
                    return $this->controller->redirect([$this->targetAction, 'id' => $tag->id]);
                }
            }
            $transaction->rollBack();
        }

        $categoriesQuery = $this->getCategoriesQuery()
            ->orderBy(['name' => SORT_ASC]);

        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);



        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'tag' => $tag,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
        ]);
    }
}
