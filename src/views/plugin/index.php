<?php
/**
 * index.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\plugin
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
