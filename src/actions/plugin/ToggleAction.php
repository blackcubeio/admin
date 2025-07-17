<?php
/**
 * ToggleAction.php
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
use blackcube\core\models\Plugin;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Class ToggleAction
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
