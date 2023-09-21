<?php
/**
 * ToggleAction.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */

namespace blackcube\admin\actions\plugin;

use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\core\models\Plugin;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ToggleAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */
class ToggleAction extends Action
{

    /**
     * @var string
     */
    public $view = '_line';

    /**
     * @param integer $id
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function run($id, PluginsHandlerInterface $pluginsHandler)
    {
        $plugin = Plugin::find()->andWhere(['id' => $id])->one();
        if ($plugin === null) {
            throw new NotFoundHttpException();
        }
        $plugin->active = !$plugin->active;
        $pluginStatus = $plugin->save(false, ['active', 'dateUpdate']);

        $pluginManager = $pluginsHandler->getPluginManager($id);
        if ($pluginManager === null) {
            throw new InvalidArgumentException();
        }

        return $this->controller->renderPartial($this->view, [
            'pluginManager' => $pluginManager,
        ]);
    }
}
