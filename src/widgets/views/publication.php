<?php
/**
 * @var $slugStatus string
 * @var $sitemapStatus string
 * @var $seoStatus string
 */
use blackcube\admin\helpers\Html;

?>
<span class="inline-flex mx-0">
    <?php echo Html::tag('span', 'U' . Html::tag('span', 'Status de l\'URL', ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$slugStatus,
    ]); ?>
    <?php echo Html::tag('span', 'S' . Html::tag('span', 'Intégration Sitemap', ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$sitemapStatus,
    ]); ?>
    <?php echo Html::tag('span', 'G' . Html::tag('span', 'Mise en place SEO', ['class' => 'tooltip-text']), [
        'class' => 'tooltip status-bar '.$seoStatus,
    ]); ?>
</span>
