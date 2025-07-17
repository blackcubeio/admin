<?php
/**
 * element-list-header.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
