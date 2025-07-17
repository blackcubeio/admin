<?php
/**
 * ToggleRegisterAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\plugin;

use blackcube\core\interfaces\PluginManagerConfigurableInterface;
use blackcube\core\interfaces\PluginsHandlerInterface;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class ToggleRegisterAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class ToggleRegisterAction extends Action
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
        $pluginManager = $pluginsHandler->getPluginManager($id);
        if ($pluginManager === null) {
            throw new NotFoundHttpException();
        }
        if ($pluginManager->getIsRegistered() === true) {
            $status = $pluginManager->unregister();
        } else {
            $status = $pluginManager->register();
            /*/if ($status === true && $pluginManager instanceof PluginManagerConfigurableInterface && $pluginManager->getConfigureRoute() !== null) {
                return $this->controller->redirect($pluginManager->getConfigureRoute());
            }/**/
        }
        return $this->controller->renderPartial($this->view, [
            'pluginManager' => $pluginManager,
        ]);
    }
}
