<?php
/**
 * _form_list.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\menu
 *
 * @var $menu \blackcube\core\models\Menu
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $menuItemsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

?>
<div class="bloc">
    <div class="bloc-title">
        <span class="title"><?php echo Module::t('menu', 'Items'); ?></span>
    </div>
</div>
<?php if ($menuItemsQuery !== null): ?>
    <div class="bloc table-container">
        <table>
            <thead>
            <tr>
                <th>
                    <?php echo Module::t('menu', 'Name'); ?>
                </th>
                <th>
                    <?php echo Module::t('menu', 'Type'); ?>
                </th>
                <th>
                    <?php echo Module::t('menu', 'Route'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('menu', 'Action'); ?>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php $level = 0; ?>
            <?php foreach($menuItemsQuery->each() as $i => $menuItem): ?>
                <?php /* @var $menuItem \blackcube\core\models\MenuItem */?>
                <?php echo $this->render('_item', ['level' => $level, 'menuItem' => $menuItem]); ?>
                <?php $baseIndex = $i ; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>
<div class="buttons">
    <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('menu', 'Add item'), ['create-item', 'menuId' => $menu->id], [
        'class' => 'button-submit'
    ]); ?>
</div>
