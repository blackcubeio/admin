<?php
/**
 * _list.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\type
 *
 * @var $pluginManagers \blackcube\core\interfaces\PluginManagerInterface[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;

$pathAlias = Module::getInstance()->adminTemplatesAlias;
$formatter = Yii::$app->formatter;
?>
<table>
    <thead>
        <tr>
            <th>
                <?php echo Module::t('plugin', 'Name'); ?>
            </th>
            <th class="tools">
                <?php echo Module::t('plugin', 'Action'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pluginManagers as $pluginId => $pluginManager): ?>
        <?php /* @var \blackcube\core\interfaces\PluginManagerInterface $pluginManager */ ?>
        <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'plugin-toggle-active-'.$pluginId]); ?>
            <?php echo $this->render('_line', ['pluginManager' => $pluginManager]); ?>
        <?php echo Html::endTag('tr'); ?>
        <?php endforeach; ?>
    </tbody>
</table>
