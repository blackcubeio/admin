<?php
/**
 * _list.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\type
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

