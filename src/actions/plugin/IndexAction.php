<?php
/**
 * IndexAction.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\actions\plugin;

use blackcube\core\interfaces\PluginsHandlerInterface;
use yii\base\Action;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Class IndexAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class IndexAction extends Action
{
    /**
     * @var string view
     */
    public $view = 'index';

    /**
     * @param PluginsHandlerInterface $pluginsHandler
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function run(PluginsHandlerInterface $pluginsHandler)
    {
        $pluginManagers = $pluginsHandler->getPluginManagers();
        return $this->controller->render($this->view, [
            'pluginManagers' => $pluginManagers,
        ]);
    }
}
