<?php
/**
 * index.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $countComposites array
 * @var $countNodes array
 * @var $countCategories array
 * @var $countTags array
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\widgets\DashboardCard;
use blackcube\admin\components\Rbac;

$formatter = Yii::$app->formatter;
?>
<main class="application-content">
    <div class="dashboard-header">
        <div class="dashboard-header-wrapper">
            <div class="dashboard-header-container">
                <div class="dashboard-header-bloc">
                    <!-- Profile -->
                    <div class="dashboard-header-bloc-wrapper">
                        <?php echo Heroicons::svg('outline/home', ['class' => 'dashboard-header-icon desktop']); ?>
                        <div>
                            <div class="flex items-center">
                                <?php echo Heroicons::svg('outline/home', ['class' => 'dashboard-header-icon mobile']); ?>
                                <h1 class="dashboard-header-title">
                                    <?php echo Module::t('dashboard', 'Dashboard'); ?>
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-6">
        <div class="dashboard-infos">
            <h2 class="dashboard-infos-title"><?php echo Module::t('dashboard', 'Overview'); ?></h2>
            <div class="dashboard-infos-cards">
                <!-- Card -->
                <?php echo DashboardCard::widget([
                    'icon' => 'outline/folder',
                    'title' => Module::t('dashboard', 'Nodes'),
                    'listTitle' => Module::t('dashboard', 'Last updated nodes'),
                    'viewPermission' => Rbac::PERMISSION_NODE_VIEW,
                    'updatePermission' => Rbac::PERMISSION_NODE_UPDATE,
                    'updateRoute' => 'node/edit',
                    'counts' => $countNodes,
                    'elementsQuery' => $nodesQuery,
                ]); ?>

                <?php echo DashboardCard::widget([
                    'icon' => 'outline/document-text',
                    'title' => Module::t('dashboard', 'Composites'),
                    'listTitle' => Module::t('dashboard', 'Last updated composites'),
                    'viewPermission' => Rbac::PERMISSION_COMPOSITE_VIEW,
                    'updatePermission' => Rbac::PERMISSION_COMPOSITE_UPDATE,
                    'updateRoute' => 'composite/edit',
                    'counts' => $countComposites,
                    'elementsQuery' => $compositesQuery,
                ]); ?>

                <?php echo DashboardCard::widget([
                    'icon' => 'outline/color-swatch',
                    'title' => Module::t('dashboard', 'Categories'),
                    'listTitle' => Module::t('dashboard', 'Last updated categories'),
                    'viewPermission' => Rbac::PERMISSION_CATEGORY_VIEW,
                    'updatePermission' => Rbac::PERMISSION_CATEGORY_UPDATE,
                    'updateRoute' => 'category/edit',
                    'counts' => $countCategories,
                    'elementsQuery' => $categoriesQuery,
                ]); ?>

                <?php echo DashboardCard::widget([
                    'icon' => 'outline/tag',
                    'title' => Module::t('dashboard', 'Tags'),
                    'listTitle' => Module::t('dashboard', 'Last updated tags'),
                    'viewPermission' => Rbac::PERMISSION_TAG_VIEW,
                    'updatePermission' => Rbac::PERMISSION_TAG_UPDATE,
                    'updateRoute' => 'tag/edit',
                    'counts' => $countTags,
                    'elementsQuery' => $tagsQuery,
                ]); ?>


            </div>
        </div>
    </div>
</main>

