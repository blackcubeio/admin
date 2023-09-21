<?php
/**
 * _form_menu_items.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\menu
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

