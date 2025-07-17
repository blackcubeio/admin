<?php
/**
 * _list.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $pluginManagers \blackcube\core\interfaces\PluginManagerInterface[]
 * @var $icon string
 * @var $title string
 * @var $additionalLinkOptions array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;
use blackcube\admin\widgets\ElementListHeader;

$pathAlias = Module::getInstance()->adminTemplatesAlias;
$formatter = Yii::$app->formatter;
?>
<div role="list" class="elements-list">
    <?php echo ElementListHeader::widget([
        'icon' => $icon,
        'title' => $title,
    ]); ?>
    <?php foreach ($pluginManagers as $pluginId => $pluginManager): ?>
        <?php echo Html::beginTag('div', ['data-ajaxify-target' => 'plugin-toggle-'.$pluginId]); ?>
            <?php echo $this->render('_line', ['pluginManager' => $pluginManager]); ?>
        <?php echo Html::endTag('div'); ?>
    <?php endforeach; ?>
</div>

