<?php
/**
 * ToggleRegisterAction.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */

namespace blackcube\admin\actions\plugin;

use blackcube\core\interfaces\PluginManagerConfigurableInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ToggleRegisterAction
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\actions\plugin
 */
class ToggleRegisterAction extends Action
{

    /**
     * @param integer $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function run($id)
    {
        $pluginsHandler = Yii::createObject(PluginsHandlerInterface::class);
        /* @var $pluginsHandler PluginsHandlerInterface */
        $pluginManager = $pluginsHandler->getPluginManager($id);
        if ($pluginManager === null) {
            throw new NotFoundHttpException();
        }
        if ($pluginManager->getIsRegistered() === true) {
            $status = $pluginManager->unregister();
        } else {
            $status = $pluginManager->register();
            if ($status === true && $pluginManager instanceof PluginManagerConfigurableInterface && $pluginManager->getConfigureRoute() !== null) {
                return $this->controller->redirect($pluginManager->getConfigureRoute());
            }
        }
        return $this->controller->redirect(['index']);
    }
}
