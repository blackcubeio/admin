<?php
/**
 * header.php
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
 * @var $previewManager \blackcube\core\components\PreviewManager
 * @var $rhis \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
?>
<!--Header Section Starts Here-->
<header class="bg-blue-900" blackcube-ajaxify="click">
    <div class="flex justify-between">
        <div class="p-1 mx-3 inline-flex">
            <!-- i class="fas fa-bars p-3 text-white"></i -->
            <span class="text-white text-lg p-2">Blackcube</span>
        </div>
        <div>
            <?php echo Html::beginForm(['search/index'], 'post', ['class' => 'p-0 flex']); ?>
                <input placeholder="Search" type="text" class="w-64 m-2 mr-0 p-1 pl-3 rounded-l border-0 bg-gray-100 outline-none inline-block">
                <button class="m-2 p-1 ml-0 rounded-r pr-3 bg-gray-100 border-0 outline-none inline-block text-blue-800"><i class="fa fa-search"></i></button>
            <?php echo Html::endForm(); ?>
        </div>
        <div class="p-1 flex flex-row">
            <?php echo Html::a(Module::t('widgets', 'Preview {icon}', [
                    'icon' => $previewManager->check() ? '<i class="fa fa-low-vision"></i>':'<i class="fa fa-eye-slash"></i>'
            ]), ['ajax/preview'], [
                'class' => 'text-blue-800 p-1 m-1 px-2 no-underline bg-gray-300 rounded text-center',
                'data-ajaxify-source' => 'header-preview',
                'data-ajaxify-target' => 'header-preview',
            ]); ?>
            <?php echo Html::a(Module::t('widgets', 'Logout'), ['authentication/logout'], ['class' => 'text-white p-2 no-underline']); ?>
            <!-- div id="ProfileDropDown" class="rounded hidden shadow-md bg-white absolute pin-t mt-12 mr-1 pin-r">
                <ul class="list-reset">
                    <li><a href="#" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">My account</a></li>
                    <li><a href="#" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">Notifications</a></li>
                    <li><hr class="border-t mx-2 border-grey-ligght"></li>
                    <li><a href="#" class="no-underline px-4 py-2 block text-black hover:bg-grey-light">Logout</a></li>
                </ul>
            </div -->
        </div>
    </div>
</header>
<!--/Header-->
