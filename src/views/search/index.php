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
 * @package blackcube\admin\views\slug
 *
 * @var $searchForm \blackcube\admin\models\SearchForm
 * @var $searchForm \blackcube\core\models\FilterActiveQuery|null
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery|null
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery|null
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery|null
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery|null
 * @var $slugsQuery \blackcube\core\models\FilterActiveQuery|null
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
?>
    <main class="overflow-hidden">
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
        <div class="bloc">
            <div class="w-full bloc-fieldset flex">
                <?php echo Html::activeTextInput($searchForm, 'search', [
                    'class' => 'flex-1 p-4 m-4 mx-0 rounded-l border-l border-t border-b border-gray-600 outline-none focus:outline-none'.($searchForm->hasErrors('search')?' error':''),
                    'placeholder' => Module::t('search', 'Search'),
                ]); ?>
                <?php echo Html::button('<i class="fa fa-search mr-2"></i> ', [
                    'type' => 'submit',
                    'class' => 'flex-none p-4 m-4 mx-0 rounded-r border-r border-t border-b border-gray-600 outline-none focus:outline-none'
                ]); ?>
            </div>
        </div>
        <div class="bloc">
            <div class="w-full bloc-fieldset inline-block">
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)): ?>
                <?php echo Html::activeCheckbox($searchForm, 'nodes', [
                    'label' => false,
                    'class' => 'checkbox', 'style' => 'display: inline-block mr-1',
                ]); ?>
                <?php echo Html::activeLabel($searchForm, 'nodes', ['class' => 'label select-none mr-5', 'style' => 'display: inline-block']); ?>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'nodes', ['value' => 0]); ?>
            <?php endif; ?>

            <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)): ?>
                <?php echo Html::activeCheckbox($searchForm, 'composites', [
                    'label' => false,
                    'class' => 'checkbox', 'style' => 'display: inline-block mr-1',
                ]); ?>
                <?php echo Html::activeLabel($searchForm, 'composites', ['class' => 'label select-none mr-5', 'style' => 'display: inline-block']); ?>
            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'composites', ['value' => 0]); ?>
            <?php endif; ?>

            <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)): ?>
                <?php echo Html::activeCheckbox($searchForm, 'categories', [
                    'label' => false,
                    'class' => 'checkbox', 'style' => 'display: inline-block mr-1',
                ]); ?>
                <?php echo Html::activeLabel($searchForm, 'categories', ['class' => 'label select-none mr-5', 'style' => 'display: inline-block']); ?>

            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'categories', ['value' => 0]); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)): ?>

                <?php echo Html::activeCheckbox($searchForm, 'tags', [
                    'label' => false,
                    'class' => 'checkbox', 'style' => 'display: inline-block mr-1',
                ]); ?>
                <?php echo Html::activeLabel($searchForm, 'tags', ['class' => 'label select-none mr-5', 'style' => 'display: inline-block']); ?>

            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'tags', ['value' => 0]); ?>
            <?php endif; ?>
            <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW)): ?>

                <?php echo Html::activeCheckbox($searchForm, 'slugs', [
                    'label' => false,
                    'class' => 'checkbox', 'style' => 'display: inline-block mr-1',
                ]); ?>
                <?php echo Html::activeLabel($searchForm, 'slugs', ['class' => 'label select-none mr-5', 'style' => 'display: inline-block']); ?>

            <?php else: ?>
                <?php echo Html::activeHiddenInput($searchForm, 'slugs', ['value' => 0]); ?>
            <?php endif; ?>
            </div>
        </div>
        <?php echo Html::endForm(); ?>
        <div class="table-container">
            <table class="w-48">
                <thead>
                <tr>
                    <th>
                        <?php echo Module::t('search', 'Name'); ?>
                        <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('composite', 'Name'); ?>" -->
                    </th>
                    <th class="type">
                        <?php echo Module::t('search', 'Type'); ?>
                    </th>
                    <th class="status">
                        <?php echo Module::t('search', 'Status'); ?>
                    </th>
                    <th class="tools">
                        <?php echo Module::t('search', 'Action'); ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW) && $nodesQuery !== null): ?>
                    <?php echo $this->render('_line', [
                        'elementsQuery' => $nodesQuery,
                        'elementType' => Node::getElementType()
                    ]); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW) && $compositesQuery !== null): ?>
                    <?php echo $this->render('_line', [
                        'elementsQuery' => $compositesQuery,
                        'elementType' => Composite::getElementType()

                    ]); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW) && $categoriesQuery !== null): ?>
                    <?php echo $this->render('_line', [
                        'elementsQuery' => $categoriesQuery,
                        'elementType' => Category::getElementType()

                    ]); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW) && $tagsQuery !== null): ?>
                    <?php echo $this->render('_line', [
                        'elementsQuery' => $tagsQuery,
                        'elementType' => Tag::getElementType()
                    ]); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_VIEW) && $slugsQuery !== null): ?>
                    <?php echo $this->render('_line', [
                        'elementsQuery' => $slugsQuery,
                        'elementType' => Slug::getElementType()
                    ]); ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
