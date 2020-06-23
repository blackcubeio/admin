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
 * @package blackcube\admin\views\plugin
 *
 * @var $pluginManager \blackcube\core\interfaces\PluginManagerInterface
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$currentCategoryId = null;
?>

    <td>
        <div class="flex items-center">
            <div class="text-gray-900 whitespace-no-wrap">
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_UPDATE) && $pluginManager->getIsRegistered() && $pluginManager->getConfigureAction() !== null): ?>
                    <?php echo Html::a($pluginManager->getName(), ['edit', 'id' => $pluginManager->getId()], ['class' => 'hover:text-blue-600 py-1']); ?>
                <?php else: ?>
                    <?php echo Html::tag('span', $pluginManager->getName(), ['class' => 'py-1']); ?>
                <?php endif; ?>
                <span class="text-xs text-gray-600 italic">V<?php echo $pluginManager->getVersion(); ?></span>
            </div>
        </div>
    </td>
    <td>
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_PLUGIN_UPDATE)): ?>
            <?php if ($pluginManager->getIsRegistered() && $pluginManager->getConfigureAction() !== null): ?>
                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $pluginManager->getId()], ['class' => 'button']); ?>
            <?php else: ?>
                <span class="button disabled"><i class="fa fa-pen-alt"></i></span>
            <?php endif; ?>
            <?php echo Html::a(($pluginManager->getIsRegistered()?'<i class="fa fa-toggle-on"></i>':' <i class="fa fa-toggle-off"></i>'), ['toggle-register', 'id' => $pluginManager->getId()], [
                'class' => 'button '.($pluginManager->getIsRegistered() ? 'published' : 'draft')]); ?>
            <?php if ($pluginManager->getIsRegistered()): ?>
            <?php echo Html::a(($pluginManager->getIsActive()?'<i class="fa fa-play"></i>':' <i class="fa fa-pause"></i>'), ['toggle', 'id' => $pluginManager->getId()], [
                'data-ajaxify-source' => 'plugin-toggle-active-'.$pluginManager->getId(),
                'class' => 'button '.($pluginManager->getIsActive() ? 'published' : 'draft')]); ?>
            <?php else: ?>
                <span class="button disabled"><i class="fa fa-pause"></i></span>
            <?php endif; ?>
        <?php endif; ?>
    </td>
