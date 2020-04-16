<?php
/**
 * _list.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\category
 *
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table>
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('category', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('category', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('category', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('category', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('category', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categoriesQuery->each() as $category): ?>
            <?php /* @var \blackcube\core\models\Category $category */ ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo Html::a($category->name, ['edit', 'id' => $category->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <span class="text-xs text-gray-600 italic">(<?php echo $category->language->id; ?>)</span>
                        </p>
                    </div>
                </td>
                <td>
                    <?php if ($category->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $category->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('category', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $category]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['delete', 'id' => $category->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $category->id])]); ?>
                    <?php if ($category->getTags()->count() > 0): ?>
                        <span class="button disabled">
                            <i class="fa fa-trash-alt"></i>
                        </span>
                    <?php else: ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $category->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($category->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $category->id], ['data-ajax' => '', 'class' => 'button '.($category->active ? 'published' : 'draft')]); ?>
                    <?php echo Html::endForm(); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
