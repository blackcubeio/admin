<?php
use blackcube\admin\helpers\Html;
use blackcube\admin\assets\StaticAsset;

$baseUrl = StaticAsset::register($this)->baseUrl;
?>
<!--Footer-->
<footer class="bg-blue-900 text-white p-2">
    <div class="flex flex-1 mx-auto justify-end"><?php echo Html::img($baseUrl.'/img/redcat.png', ['class' => 'object-scale-down h-8']); ?></div>
</footer>
<!--/footer-->
