<?php
/**
 * sidebar.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var string $controllerUid
 * @var string $adminUid
 * @var string|null $version
 * @var array $widgets
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\Aurelia;
use blackcube\admin\widgets\Navbar;
?>
<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div blackcube-menu="" class="menu menu-mobile" role="dialog" aria-modal="true">
    <!--
      Off-canvas menu overlay, show/hide based on off-canvas menu state.

      Entering: "transition-opacity ease-linear duration-300"
        From: "opacity-0"
        To: "opacity-100"
      Leaving: "transition-opacity ease-linear duration-300"
        From: "opacity-100"
        To: "opacity-0"
    -->
    <div  data-ref="overlay" class="menu-mobile-overlay closed" aria-hidden="true"></div>

    <!--
      Off-canvas menu, show/hide based on off-canvas menu state.

      Entering: "transition ease-in-out duration-300 transform"
        From: "-translate-x-full"
        To: "translate-x-0"
      Leaving: "transition ease-in-out duration-300 transform"
        From: "translate-x-0"
        To: "-translate-x-full"
    -->
    <div  data-ref="offcanvas" class="menu-mobile-offcanvas closed">
        <!--
          Close button, show/hide based on off-canvas menu state.

          Entering: "ease-in-out duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div  data-ref="closepanel" class="menu-mobile-close closed">
            <button class="menu-mobile-btn"  data-ref="close">
                <span class="sr-only"><?php Module::t('common', 'Close sidebar'); ?></span>
                <?php echo Heroicons::svg('outline/x', ['class' => 'menu-mobile-img']); ?>
            </button>
        </div>

        <div class="menu-logo">
            <!-- img class="menu-logo-img" src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg" alt="Workflow" -->
            <span class="text-2xl font-semibold leading-7 text-gray-900 sm:truncate">Blackcube</span>
            <?php if($version !== null): ?>
                <span class="text-xs text-gray-600 italic ml-2"><?php echo $version; ?></span>
            <?php endif; ?>
        </div>
        <div class="menu-mobile-navbar-wrapper">
            <?php echo Navbar::widget([
                'adminUid' => $adminUid,
                'controllerUid' => $controllerUid,
                'widgets' => $widgets,
            ])?>
        </div>
    </div>

    <div class="flex-shrink-0 w-14" aria-hidden="true">
        <!-- Dummy element to force sidebar to shrink to fit close icon -->
    </div>
</div>

<!-- Static sidebar for desktop -->
<div blackcube-menu="" class="menu menu-desktop">
    <div class="menu-desktop-wrapper">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="menu-desktop-sidebar">
            <div class="menu-logo">
                <!-- img class="menu-logo-img" src="https://tailwindui.com/img/logos/workflow-logo-indigo-600-mark-gray-800-text.svg" alt="Workflow" -->
                <span class="text-2xl font-semibold leading-7 text-gray-900 sm:truncate">Blackcube</span>
                <?php if($version !== null): ?>
                    <span class="text-xs text-gray-600 italic ml-2"><?php echo $version; ?></span>
                <?php endif; ?>
            </div>
            <div class="menu-desktop-navbar-wrapper">
                <?php echo Navbar::widget([
                    'adminUid' => $adminUid,
                    'controllerUid' => $controllerUid,
                    'widgets' => $widgets,
                ])?>
            </div>
        </div>
    </div>
</div>
