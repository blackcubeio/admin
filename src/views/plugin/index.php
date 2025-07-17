<?php
/**
 * index.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $pluginManagers \blackcube\core\interfaces\PluginManagerInterface[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
<main class="application-content">
    <div class="elements" data-ajaxify-target="plugins-search">
        <?php echo $this->render('_list', [
            'icon' => 'outline/beaker',
            'title' => Module::t('plugin', 'Plugins'),
            'pluginManagers' => $pluginManagers,
            'additionalLinkOptions' => [
                'data-ajaxify-source' => 'plugins-search'
            ]
        ]); ?>
    </div>
</main>
