<?php
/**
 * CreateAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
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
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\tag
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
        $tag = Yii::createObject(Tag::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $tag,
        ]);
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $tag);

        $blocs = $tag->getBlocs()->all();
        $transaction = Module::getInstance()->db->beginTransaction();
        $result = TagHelper::saveElement($tag, $blocs, $slugForm);
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
        $categoriesQuery = $this->getCategoriesQuery()
            ->orderBy(['name' => SORT_ASC]);
        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'tag' => $tag,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'categoriesQuery' => $categoriesQuery,
        ]);
    }
}
