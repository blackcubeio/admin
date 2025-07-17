<?php
/**
 * _form_menu_items.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $menuItemsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\widgets\MenuItemCard;

?>

        <?php if ($menuItemsQuery !== null): ?>
            <?php $level = 0; ?>
            <?php foreach($menuItemsQuery->each() as $i => $menuItem): ?>
                <?php echo $this->render('_item', [
                    'level' => $level,
                    'menuItem' => $menuItem
                ]); ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php echo  Html::endTag('div'); ?>

