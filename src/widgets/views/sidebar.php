<?php
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
?>
<!--Sidebar-->
<aside id="sidebar" class="bg-gray-100 w-1/2 md:w-1/6 lg:w-1/6 border-r hidden md:block lg:block">

    <ul class="list-none flex flex-col">
        <li class=" w-full h-full py-3 px-2 border-b bg-white">
            <a href="index.html"
               class="font-sans font-hairline hover:font-normal text-sm text-gray-700 no-underline">
                <i class="fas fa-tachometer-alt float-left mx-2 mt-1"></i>
                <span>Dashboard</span>
                <span><i class="fas fa-angle-right float-right mt-2"></i></span>
            </a>
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
        <li class="w-full h-full py-3 px-2 border-b ">
            <?php echo Html::beginTag('a', ['href' => Url::to(['bloc-type/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
            <i class="fa fa-cube float-left mx-2 mt-2"></i>
            Types de blocs
            <span><i class="fa fa-angle-right float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
        </li>
        <li class="w-full h-full py-3 px-2 border-b ">
            <?php echo Html::beginTag('a', ['href' => Url::to(['node/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
            <i class="fa fa-archive float-left mx-2 mt-2"></i>
            Rubriques
            <span><i class="fa fa-angle-right float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
        </li>
        <li class="w-full h-full py-3 px-2 border-b ">
            <?php echo Html::beginTag('a', ['href' => Url::to(['composite/index']), 'class' => 'font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline']); ?>
            <i class="fa fa-file float-left mx-2 mt-2"></i>
            Contenus
            <span><i class="fa fa-angle-right float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
        </li>
        <li class="w-full h-full py-3 px-2 border-b border-light-border">
            <a href="buttons.html"
               class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                <i class="fas fa-grip-horizontal float-left mx-2"></i>
                Buttons
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>
        <li class="w-full h-full py-3 px-2 border-b border-light-border">
            <a href="tables.html"
               class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                <i class="fas fa-table float-left mx-2"></i>
                Tables
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>
        <li class="w-full h-full py-3 px-2 border-b border-light-border">
            <a href="ui.html"
               class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                <i class="fab fa-uikit float-left mx-2"></i>
                Ui components
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>
        <li class="w-full h-full py-3 px-2 border-b border-300-border">
            <a href="modals.html" class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                <i class="fas fa-square-full float-left mx-2"></i>
                Modals
                <span><i class="fa fa-angle-right float-right"></i></span>
            </a>
        </li>
        <li class="w-full h-full py-3 px-2">
            <a href="#"
               class="font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                <i class="far fa-file float-left mx-2"></i>
                Pages
                <span><i class="fa fa-angle-down float-right"></i></span>
            </a>
            <ul class="list-reset -mx-2 bg-white-medium-dark">
                <li class="border-t mt-2 border-light-border w-full h-full px-2 py-3">
                    <a href="login.html"
                       class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                        Login Page
                        <span><i class="fa fa-angle-right float-right"></i></span>
                    </a>
                </li>
                <li class="border-t border-light-border w-full h-full px-2 py-3">
                    <a href="register.html"
                       class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                        Register Page
                        <span><i class="fa fa-angle-right float-right"></i></span>
                    </a>
                </li>
                <li class="border-t border-light-border w-full h-full px-2 py-3">
                    <a href="404.html"
                       class="mx-4 font-sans font-hairline hover:font-normal text-sm text-nav-item no-underline">
                        404 Page
                        <span><i class="fa fa-angle-right float-right"></i></span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>

</aside>
<!--/Sidebar-->
