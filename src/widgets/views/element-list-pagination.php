<?php
/**
 * element-list-pagination.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\dashboard
 *
 * @var $beginPage int
 * @var $endPage int
 * @var $previousPage int
 * @var $nextPage int
 * @var $currentPage int
 * @var $pagination \yii\data\Pagination
 * @var $additionalLinkOptions array
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;

?>
<div class="pagination">
    <div class="pagination-mobile">
        <?php echo Html::a(Module::t('widgets', 'Previous'), $pagination->createUrl($previousPage), ['class' => 'relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'] + $additionalLinkOptions); ?>
        <?php echo Html::a(Module::t('widgets', 'Next'), $pagination->createUrl($nextPage), ['class' => 'ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50'] + $additionalLinkOptions); ?>
    </div>
    <div class="pagination-desktop">
        <div>
            <p class="pagination-desktop-info">
                <?php
                $countStr = Module::t('widgets','Showing {start} to {end} of {count} results', [
                    'start' => min($pagination->offset + 1, $pagination->totalCount),
                    'end' => min($pagination->offset + $pagination->pageSize, $pagination->totalCount),
                    'count' => $pagination->totalCount
                ]);
                echo preg_replace('/([0-9]+)/', '<span class="font-medium">$1</span>', $countStr);
                ?>
            </p>
        </div>
        <?php if($pagination->pageCount > 1): ?>
        <div>
            <nav class="pagination-desktop-nav" aria-label="Pagination">
                <?php echo Html::beginTag('a', ['href' => $pagination->createUrl($previousPage), 'class' => 'pagination-desktop-nav-link'] + $additionalLinkOptions); ?>
                    <span class="sr-only"><?php echo Module::t('common', 'Previous'); ?></span>
                    <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'pagination-desktop-nav-icon']); ?>
                <?php echo Html::endTag('a'); ?>

                <?php for($i = $beginPage; $i <= $endPage; $i++): ?>

                    <?php
                    $class = 'pagination-desktop-nav-link';
                    if ($currentPage === $i) {
                        $class .= ' active';
                    }
                    ?>
                    <?php echo Html::beginTag('a', ['href' => $pagination->createUrl($i), 'class' => $class] + $additionalLinkOptions); ?>
                    <!-- Current: "z-10 bg-indigo-50 border-indigo-500 text-indigo-600", Default: "bg-white border-gray-300 text-gray-500 hover:bg-gray-50" -->
                    <!-- a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium" -->
                        <?php echo $i + 1; ?>
                    <?php echo Html::endTag('a'); ?>
                <?php endfor; ?>
                <?php echo Html::beginTag('a', ['href' => $pagination->createUrl($nextPage), 'class' => 'pagination-desktop-nav-link'] + $additionalLinkOptions); ?>
                    <span class="sr-only"><?php echo Module::t('common', 'Next'); ?></span>
                    <?php echo Heroicons::svg('solid/chevron-right', ['class' => 'pagination-desktop-nav-icon']); ?>
                <?php echo Html::endTag('a'); ?>
            </nav>
        </div>
        <?php endif; ?>
    </div>
</div>
