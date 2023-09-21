<?php
/**
 * element-list-header.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\dashboard
 *
 * @var $title string
 * @var $icon string
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;

?>
<div class="header">
    <div class="header-wrapper">
        <span class="header-image">
            <?php echo Heroicons::svg($icon, ['class' => 'header-icon']); ?>
        </span>
        <div class="header-title">
            <?php echo $title; ?>
        </div>
    </div>
</div>
