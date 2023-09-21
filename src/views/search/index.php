<?php
/**
 * index.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\slug
 *
 * @var $searchForm \blackcube\admin\models\SearchForm
 * @var $searchForm \yii\data\ActiveDataProvider|null
 * @var $nodesProvider \yii\data\ActiveDataProvider|null
 * @var $compositesProvider \yii\data\ActiveDataProvider|null
 * @var $categoriesProvider \yii\data\ActiveDataProvider|null
 * @var $tagsProvider \yii\data\ActiveDataProvider|null
 * @var $slugsProvider \yii\data\ActiveDataProvider|null
 * @var $currentModuleUid string
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\components\Rbac;
use blackcube\core\models\Category;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Slug;
use blackcube\core\models\Tag;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\widgets\ElementListHeader;
use blackcube\admin\widgets\ElementListPagination;
use blackcube\admin\widgets\ElementCard;
?>
    <main class="application-content">
        <?php echo Html::beginForm('', 'post', ['class' => 'search-form']); ?>
        <div class="search-form-wrapper">
            <div class="relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <?php echo Heroicons::svg('solid/search', ['class' => 'h-5 w-5 text-gray-400']); ?>
                </div>
                <?php echo Html::activeTextInput($searchForm, 'search', [
                    'class' => 'focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md',
                    'placeholder' => Module::t('common', 'Search'),
                    'name' => 'search',
                ]); ?>
            </div>

            <fieldset class="mt-6 flex flex-row flex-wrap items-start space-y-0 space-x-10">
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)): ?>
            <div class="relative flex items-start">
                <div class="flex items-center h-5">
                    <?php echo Html::activeCheckbox($searchForm, 'nodes', [
                        'label' => false,
                        'class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded',
                        'name' => 'nodes',
                    ]); ?>
                </div>
                <div class="ml-3 text-sm">
                    <?php echo Html::activeLabel($searchForm, 'nodes', ['class' => 'font-medium text-gray-700']); ?>
                    <span class="text-gray-500">
                        <span class="sr-only"><?php echo Module::t('search', 'Search nodes'); ?> </span>
                    </span>
                </div>
            </div>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'nodes', ['value' => 0, 'name' => 'nodes']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)): ?>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <?php echo Html::activeCheckbox($searchForm, 'composites', [
                            'label' => false,
                            'class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded',
                            'name' => 'composites',
                        ]); ?>
                    </div>
                    <div class="ml-3 text-sm">
                        <?php echo Html::activeLabel($searchForm, 'composites', ['class' => 'font-medium text-gray-700']); ?>
                        <span class="text-gray-500">
                        <span class="sr-only"><?php echo Module::t('search', 'Search composites'); ?> </span>
                    </span>
                    </div>
                </div>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'composites', ['value' => 0, 'name' => 'composites']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)): ?>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <?php echo Html::activeCheckbox($searchForm, 'categories', [
                            'label' => false,
                            'class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded',
                            'name' => 'categories',
                        ]); ?>
                    </div>
                    <div class="ml-3 text-sm">
                        <?php echo Html::activeLabel($searchForm, 'categories', ['class' => 'font-medium text-gray-700']); ?>
                        <span class="text-gray-500">
                        <span class="sr-only"><?php echo Module::t('search', 'Search categories'); ?> </span>
                    </span>
                    </div>
                </div>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'categories', ['value' => 0, 'name' => 'categories']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)): ?>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <?php echo Html::activeCheckbox($searchForm, 'tags', [
                            'label' => false,
                            'class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded',
                            'name' => 'tags',
                        ]); ?>
                    </div>
                    <div class="ml-3 text-sm">
                        <?php echo Html::activeLabel($searchForm, 'tags', ['class' => 'font-medium text-gray-700']); ?>
                        <span class="text-gray-500">
                        <span class="sr-only"><?php echo Module::t('search', 'Search tags'); ?> </span>
                    </span>
                    </div>
                </div>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'tags', ['value' => 0, 'name' => 'tags']); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)): ?>
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <?php echo Html::activeCheckbox($searchForm, 'slugs', [
                            'label' => false,
                            'class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded',
                            'name' => 'slugs',
                        ]); ?>
                    </div>
                    <div class="ml-3 text-sm">
                        <?php echo Html::activeLabel($searchForm, 'slugs', ['class' => 'font-medium text-gray-700']); ?>
                        <span class="text-gray-500">
                        <span class="sr-only"><?php echo Module::t('search', 'Search slugs'); ?> </span>
                    </span>
                    </div>
                </div>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'slugs', ['value' => 0, 'name' => 'slugs']); ?>
            <?php endif; ?>
        </fieldset>
        </div>
        <?php echo Html::endForm(); ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW) && $nodesProvider !== null && $nodesProvider->totalCount > 0): ?>
        <div class="elements" data-ajaxify-target="nodes-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/folder',
                'title' => Module::t('search', 'Nodes'),
                'elementsProvider' => $nodesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'nodes-search'
                ]
            ]); ?>
        </div>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW) && $compositesProvider !== null && $compositesProvider->totalCount > 0): ?>
        <div class="elements" data-ajaxify-target="composites-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/document-text',
                'title' => Module::t('search', 'Composites'),
                'elementsProvider' => $compositesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'composites-search'
                ]
            ]); ?>
        </div>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW) && $categoriesProvider !== null && $categoriesProvider->totalCount > 0): ?>
        <div class="elements" data-ajaxify-target="categories-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/color-swatch',
                'title' => Module::t('search', 'Categories'),
                'elementsProvider' => $categoriesProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'categories-search'
                ]
            ]); ?>
        </div>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW) && $tagsProvider !== null && $tagsProvider->totalCount > 0): ?>
        <div class="elements" data-ajaxify-target="tags-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/tag',
                'title' => Module::t('search', 'Tags'),
                'elementsProvider' => $tagsProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'tags-search'
                ]
            ]); ?>
        </div>
        <?php endif; ?>

        <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW) && $slugsProvider !== null && $slugsProvider->totalCount > 0): ?>
        <div class="elements" data-ajaxify-target="slugs-search">
            <?php echo $this->render('_list', [
                'icon' => 'outline/link',
                'title' => Module::t('search', 'Slugs'),
                'elementsProvider' => $slugsProvider,
                'additionalLinkOptions' => [
                    'data-ajaxify-source' => 'slugs-search'
                ]
            ]); ?>
        </div>
        <?php endif; ?>

    </main>
