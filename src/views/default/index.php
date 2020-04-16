<?php
/**
 * index.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\default
 *
 * @var $countComposites array
 * @var $countNodes array
 * @var $countCategories array
 * @var $countTags array
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use \blackcube\admin\widgets\Sidebar;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="bloc">
            <div class="bloc-title">
                <span class="title">Statistiques</span>
            </div>
        </div>
        <div class="bloc">
            <div class="bloc-regular w-full md:w-1/2">
                Nodes <?php echo $countNodes['global'];?> / <?php echo $countNodes['active'];?> / <?php echo $countNodes['activeWithSlug'];?>
                <?php echo Html::tag('blackcube-pie', '', [
                    'inactive' => $countNodes['global'] - $countNodes['active'],
                    'active-url' => $countNodes['activeWithSlug'],
                    'active-no-url' => $countNodes['active'] - $countNodes['activeWithSlug'],
                    'inactive-label' => 'Inactif ('.($countNodes['global'] - $countNodes['active']).')',
                    'active-url-label' => 'Actif ('.$countNodes['activeWithSlug'].')',
                    'active-no-url-label' => 'Actif sans URL ('.($countNodes['active'] - $countNodes['activeWithSlug']).')',
                ]); ?>
            </div>
            <div class="bloc-regular w-full md:w-1/2">
                Composites <?php echo $countComposites['global'];?> / <?php echo $countComposites['active'];?> / <?php echo $countComposites['activeWithSlug'];?>
                <?php echo Html::tag('blackcube-pie', '', [
                    'inactive' => $countComposites['global'] - $countComposites['active'],
                    'active-url' => $countComposites['activeWithSlug'],
                    'active-no-url' => $countComposites['active'] - $countComposites['activeWithSlug'],
                    'inactive-label' => 'Inactif ('.($countComposites['global'] - $countComposites['active']).')',
                    'active-url-label' => 'Actif ('.$countComposites['activeWithSlug'].')',
                    'active-no-url-label' => 'Actif sans URL ('.($countComposites['active'] - $countComposites['activeWithSlug']).')',
                ]); ?>
            </div>
        </div>
        <div class="bloc">
            <div class="bloc-regular w-full md:w-1/2">
                Categories <?php echo $countCategories['global'];?> / <?php echo $countCategories['active'];?> / <?php echo $countCategories['activeWithSlug'];?>
                <?php echo Html::tag('blackcube-pie', '', [
                    'inactive' => $countCategories['global'] - $countCategories['active'],
                    'active-url' => $countCategories['activeWithSlug'],
                    'active-no-url' => $countCategories['active'] - $countCategories['activeWithSlug'],
                    'inactive-label' => 'Inactif ('.($countCategories['global'] - $countCategories['active']).')',
                    'active-url-label' => 'Actif ('.$countCategories['activeWithSlug'].')',
                    'active-no-url-label' => 'Actif sans URL ('.($countCategories['active'] - $countCategories['activeWithSlug']).')',
                ]); ?>
            </div>
            <div class="bloc-regular w-full md:w-1/2">
                Tags <?php echo $countTags['global'];?> / <?php echo $countTags['active'];?> / <?php echo $countTags['activeWithSlug'];?>
                <?php echo Html::tag('blackcube-pie', '', [
                    'inactive' => $countTags['global'] - $countTags['active'],
                    'active-url' => $countTags['activeWithSlug'],
                    'active-no-url' => $countTags['active'] - $countTags['activeWithSlug'],
                    'inactive-label' => 'Inactif ('.($countTags['global'] - $countTags['active']).')',
                    'active-url-label' => 'Actif ('.$countTags['activeWithSlug'].')',
                    'active-no-url-label' => 'Actif sans URL ('.($countTags['active'] - $countTags['activeWithSlug']).')',
                ]); ?>
            </div>
        </div>

    </main>
</div>
