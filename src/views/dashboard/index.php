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
 * @package blackcube\admin\views\dashboard
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
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;

$formatter = Yii::$app->formatter;
?>
    <main class="overflow-hidden">
        <div class="form">
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('dashboard', 'Dashboard'); ?></span>
                </div>
            </div>
            <div class="bloc pb-4">
                <div class="bloc-child w-full md:w-1/2">
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Composites stats ({count})', ['count' => $compositesQuery->count()]); ?></span>
                    </div>
                    <div class="pb-2">
                        <?php echo Html::tag('blackcube-pie', '', [
                            'class' => 'block text-center',
                            'inactive' => $countComposites['global'] - $countComposites['active'],
                            'active-url' => $countComposites['activeWithSlug'],
                            'active-no-url' => $countComposites['active'] - $countComposites['activeWithSlug'],
                            'inactive-label' => Module::t('dashboard', 'Inactive ({count})', ['count' => ($countComposites['global'] - $countComposites['active'])]),
                            'active-url-label' => Module::t('dashboard', 'Active ({count})', ['count' => $countComposites['activeWithSlug']]),
                            'active-no-url-label' => Module::t('dashboard', 'Active no URL ({count})', ['count' => ($countComposites['active'] - $countComposites['activeWithSlug'])]),
                        ]); ?>

                    </div>
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Last updated composites'); ?></span>
                    </div>
                    <ul>
                        <?php foreach($compositesQuery->each() as $composite): ?>
                            <?php /* @var $composite \blackcube\core\models\Composite */ ?>
                            <li class="flex justify-between">
                                <span>
                                    <?php echo Html::a($composite->name, ['composite/edit', 'id' => $composite->id], [
                                        'class' => 'hover:text-blue-600'
                                    ]); ?>
                                    <span class="text-xs italic text-gray-500">#<?php echo $composite->id; ?></span>
                                </span>
                                <span class="text-xs italic text-gray-500"><?php echo $formatter->asRelativeTime(new DateTime($composite->dateUpdate)); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="bloc-child w-full md:w-1/2">
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Nodes stats ({count})', ['count' => $nodesQuery->count()]); ?></span>
                    </div>
                    <div class="pb-2">
                        <?php echo Html::tag('blackcube-pie', '', [
                            'class' => 'block text-center',
                            'inactive' => $countNodes['global'] - $countNodes['active'],
                            'active-url' => $countNodes['activeWithSlug'],
                            'active-no-url' => $countNodes['active'] - $countNodes['activeWithSlug'],
                            'inactive-label' => Module::t('dashboard', 'Inactive ({count})', ['count' => ($countNodes['global'] - $countNodes['active'])]),
                            'active-url-label' => Module::t('dashboard', 'Active ({count})', ['count' => $countNodes['activeWithSlug']]),
                            'active-no-url-label' => Module::t('dashboard', 'Active no URL ({count})', ['count' => ($countNodes['active'] - $countNodes['activeWithSlug'])]),
                        ]); ?>
                    </div>
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Last updated nodes'); ?></span>
                    </div>
                    <ul>
                        <?php foreach($nodesQuery->each() as $node): ?>
                            <?php /* @var $node \blackcube\core\models\Node */ ?>
                            <li class="flex justify-between">
                                <span>
                                    <?php echo Html::a($node->name, ['node/edit', 'id' => $node->id], [
                                            'class' => 'hover:text-blue-600'
                                    ]); ?>
                                    <span class="text-xs italic text-gray-500">#<?php echo $node->id; ?></span>
                                </span>
                                <span class="text-xs italic text-gray-500"><?php echo $formatter->asRelativeTime(new DateTime($node->dateUpdate)); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="bloc">
                <div class="bloc-child w-full md:w-1/2">
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Tags stats ({count})', ['count' => $tagsQuery->count()]); ?></span>
                    </div>
                    <div class="pb-2">
                        <?php echo Html::tag('blackcube-pie', '', [
                            'class' => 'block text-center',
                            'inactive' => $countTags['global'] - $countTags['active'],
                            'active-url' => $countTags['activeWithSlug'],
                            'active-no-url' => $countTags['active'] - $countTags['activeWithSlug'],
                            'inactive-label' => Module::t('dashboard', 'Inactive ({count})', ['count' => ($countTags['global'] - $countTags['active'])]),
                            'active-url-label' => Module::t('dashboard', 'Active ({count})', ['count' => $countTags['activeWithSlug']]),
                            'active-no-url-label' => Module::t('dashboard', 'Active no URL ({count})', ['count' => ($countTags['active'] - $countTags['activeWithSlug'])]),
                        ]); ?>
                    </div>
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Last updated tags'); ?></span>
                    </div>
                    <ul>
                        <?php foreach($tagsQuery->each() as $tag): ?>
                            <?php /* @var $tag \blackcube\core\models\Tag */ ?>
                            <li class="flex justify-between">
                                <span>
                                    <?php echo Html::a($tag->name, ['tag/edit', 'id' => $tag->id], [
                                        'class' => 'hover:text-blue-600'
                                    ]); ?>
                                    <span class="text-xs italic text-gray-500">#<?php echo $tag->id; ?></span>
                                </span>
                                <span class="text-xs italic text-gray-500"><?php echo $formatter->asRelativeTime(new DateTime($tag->dateUpdate)); ?></span>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
                <div class="bloc-child w-full md:w-1/2">
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Categories stats ({count})', ['count' => $categoriesQuery->count()]); ?></span>
                    </div>
                    <div class="pb-2">
                        <?php echo Html::tag('blackcube-pie', '', [
                            'class' => 'block text-center',
                            'inactive' => $countCategories['global'] - $countCategories['active'],
                            'active-url' => $countCategories['activeWithSlug'],
                            'active-no-url' => $countCategories['active'] - $countCategories['activeWithSlug'],
                            'inactive-label' => Module::t('dashboard', 'Inactive ({count})', ['count' => ($countCategories['global'] - $countCategories['active'])]),
                            'active-url-label' => Module::t('dashboard', 'Active ({count})', ['count' => $countCategories['activeWithSlug']]),
                            'active-no-url-label' => Module::t('dashboard', 'Active no URL ({count})', ['count' => ($countCategories['active'] - $countCategories['activeWithSlug'])]),
                        ]); ?>
                    </div>
                    <div class="bloc-subtitle">
                        <span class="title"><?php echo Module::t('dashboard', 'Last updated categories'); ?></span>
                    </div>
                    <ul>
                        <?php foreach($categoriesQuery->each() as $category): ?>
                            <?php /* @var $category \blackcube\core\models\Category */ ?>
                            <li class="flex justify-between">
                                <span>
                                    <?php echo Html::a($category->name, ['category/edit', 'id' => $category->id], [
                                        'class' => 'hover:text-blue-600'
                                    ]); ?>
                                    <span class="text-xs italic text-gray-500">#<?php echo $category->id; ?></span>
                                </span>
                                <span class="text-xs italic text-gray-500"><?php echo $formatter->asRelativeTime(new DateTime($category->dateUpdate)); ?></span>
                            </li>
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>
        </div>
    </main>

