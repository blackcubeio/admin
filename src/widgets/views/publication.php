<?php
/**
 * publication.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $slugStatus string
 * @var $sitemapStatus string
 * @var $seoStatus string
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\helpers\Heroicons;

?>
<!-- span class="inline-flex mx-0">
    <?php echo Html::tag('span', 'U' . Html::tag('span',
        Module::t('widgets', 'URL Status'),
        ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$slugStatus,
    ]); ?>
    <?php echo Html::tag('span', 'S' . Html::tag('span',
        Module::t('widgets', 'Sitemap integration'),
        ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$sitemapStatus,
    ]); ?>
    <?php echo Html::tag('span', 'G' . Html::tag('span',
        Module::t('widgets', 'SEO integration'),
        ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$seoStatus,
    ]); ?>
</span -->
<span class="publication">
    <?php echo Html::tag('span', Heroicons::svg('outline/link', ['class' => 'publication-tag-icon']), ['class' => 'publication-tag '.$slugStatus]); ?>
    <?php echo Html::tag('span', Heroicons::svg('outline/map', ['class' => 'publication-tag-icon']), ['class' => 'publication-tag '.$sitemapStatus]); ?>
    <?php echo Html::tag('span', Heroicons::svg('outline/search-circle', ['class' => 'publication-tag-icon']), ['class' => 'publication-tag '.$seoStatus]); ?>
</span>