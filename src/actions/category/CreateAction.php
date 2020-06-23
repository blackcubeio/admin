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
 * @package blackcube\admin\actions\category
 */

namespace blackcube\admin\actions\category;

use blackcube\admin\actions\BaseElementAction;
use blackcube\admin\helpers\Category as CategoryHelper;
use blackcube\admin\models\SlugForm;
use blackcube\core\interfaces\PluginHookInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Category;
use blackcube\core\models\Language;
use blackcube\core\models\Type;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class CreateAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\category
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
        $category = Yii::createObject(Category::class);
        $slugForm = Yii::createObject([
            'class' => SlugForm::class,
            'element' => $category
        ]);
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface */
        $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_LOAD, $category);

        $blocs = $category->getBlocs()->all();
        $transaction = Module::getInstance()->db->beginTransaction();
        $result = CategoryHelper::saveElement($category, $blocs, $slugForm);
        $validatePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_VALIDATE, $category);
        $validatePlugins = array_reduce($validatePlugins, function($accumulator, $item) {
            return $accumulator && $item;
        }, true);

        if ($result === true && $validatePlugins === true) {
            $savePlugins = $pluginsHandler->runHook(PluginHookInterface::PLUGIN_HOOK_SAVE, $category);
            $savePlugins = array_reduce($savePlugins, function($accumulator, $item) {
                return $accumulator && $item;
            }, true);
            if ($savePlugins === true) {
                $transaction->commit();
                return $this->controller->redirect([$this->targetAction, 'id' => $category->id]);
            }
        }
        $transaction->rollBack();
        $languagesQuery = Language::find()->active()->orderBy(['name' => SORT_ASC]);
        $typesQuery = $this->getTypesQuery()
            ->orderBy(['name' => SORT_ASC]);
        return $this->controller->render($this->view, [
            'pluginsHandler' => $pluginsHandler,
            'category' => $category,
            'slugForm' => $slugForm,
            'typesQuery' => $typesQuery,
            'blocs' => $blocs,
            'languagesQuery' => $languagesQuery,
        ]);
    }
}
