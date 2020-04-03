<?php
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
?>
<!--Sidebar-->
<aside id="sidebar" class="bg-gray-100 w-1/2 md:w-56 lg:w-64 border-r hidden md:block lg:block">

    <ul class="list-none flex flex-col">
        <li class=" w-full h-full py-3 px-2 border-b bg-white">
            <?php echo Html::beginTag('a', ['href' => Url::to(['default/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                <i class="fas fa-tachometer-alt float-left mx-2 mt-1"></i>
                <span>Dashboard</span>
                <span><i class="fas fa-angle-right float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
        </li>
        <li class="w-full h-full py-3 px-2 pb-0">
            <?php echo Html::beginTag('a', ['href' => '#', 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
            <i class="fa fa-tools float-left mx-2 mt-2"></i>
            Paramétrage
            <span><i class="fa fa-angle-down float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
            <ul class="pl-2 mt-3 -mx-2 bg-gray-200">
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['parameter/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-wrench float-left mx-2 mt-2"></i>
                    Paramètres
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['type/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-file-invoice float-left mx-2 mt-2"></i>
                    Types
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['bloc-type/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-cube float-left mx-2 mt-2"></i>
                    Types de blocs
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
            </ul>
        </li>
        <li class="w-full h-full py-3 px-2">
            <?php echo Html::beginTag('a', ['href' => '#', 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
            <i class="fa fa-book float-left mx-2 mt-2"></i>
            Gestion
            <span><i class="fa fa-angle-down float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
            <ul class="pl-2 mt-3 -mx-2 bg-gray-200">
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['composite/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-file float-left mx-2 mt-2"></i>
                    Contenus
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['node/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-sitemap float-left mx-2 mt-2"></i>
                    Rubriques
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['category/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fas fa-tags float-left mx-2 mt-2"></i>
                    Catégories
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
                <li class="w-full h-full py-3 px-2 border-b ">
                    <?php echo Html::beginTag('a', ['href' => Url::to(['tag/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
                    <i class="fa fa-tag float-left mx-2 mt-2"></i>
                    Tags
                    <span><i class="fa fa-angle-right float-right mt-2"></i></span>
                    <?php echo Html::endTag('a'); ?>
                </li>
            </ul>
        </li>

    </ul>

</aside>
<!--/Sidebar-->
