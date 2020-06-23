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
 * @package blackcube\admin\views\node
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $nodesProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginAdminHookInterface;
use yii\widgets\LinkPager;

$formatter = Yii::$app->formatter;
?>
    <main class="overflow-hidden">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_LIST_HEAD); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="table-container">
            <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
                <?php $widgets = $pluginsHandler->runWidgetHook(PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_LIST_BEFORE_LIST); ?>
                <?php foreach ($widgets as $widget): ?>
                    <?php echo $widget; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div blackcube-ajaxify="click" blackcube-attach-modal="">
                <?php echo $this->render('_list', [
                    'pluginsHandler' => $pluginsHandler,
                    'nodesProvider' => $nodesProvider
                ]); ?>
            </div>
            <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
                <?php $widgets = $pluginsHandler->runWidgetHook(PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_LIST_AFTER_LIST); ?>
                <?php foreach ($widgets as $widget): ?>
                    <?php echo $widget; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="text-center">
                <?php echo LinkPager::widget([
                    'pagination' => $nodesProvider->pagination,
                    'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                    'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                    'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                ]); ?>
            </div>
            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('node', 'Create'), ['create'], ['class' => 'button-submit']); ?>
            </div>
        </div>
    </main>

