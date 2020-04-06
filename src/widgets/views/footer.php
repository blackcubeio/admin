<?php
/**
 * footer.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets\views
 *
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\assets\StaticAsset;

$baseUrl = StaticAsset::register($this)->baseUrl;
?>
<!--Footer-->
<footer class="bg-blue-900 text-white p-2">
    <div class="flex flex-1 mx-auto justify-end"><?php echo Html::img($baseUrl.'/img/redcat.png', ['class' => 'object-scale-down h-8']); ?></div>
</footer>
<!--/footer-->
