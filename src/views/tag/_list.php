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
 * @package blackcube\admin\views\tag
 *
 * @var $this yii\web\View
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$currentCategoryId = null;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('tag', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('tag', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('tag', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('tag', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('tag', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tagsQuery->each() as $tag): ?>
            <?php /* @var \blackcube\core\models\Tag $tag */ ?>
            <?php if ($currentCategoryId !== $tag->categoryId): ?>
                <?php $currentCategoryId = $tag->categoryId; ?>
                <tr>
                    <td colspan="4" class="category">
                        <?php echo $tag->category->name; ?>
                        <?php /*/ if($tag->category->active): ?><span class="text-xxs text-white bg-green-600 rounded-full p-1 ml-4"><i class="fa fa-eye"></i></span><?php else: ?><span class="text-xxs text-white bg-red-600 rounded-full p-1 ml-4"><i class="fa fa-eye-slash"></i></span><?php endif; /**/ ?>
                    </td>
                </tr>
            <?php endif; ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo Html::a($tag->name, ['edit', 'id' => $tag->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php if ($tag->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $tag->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('tag', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $tag]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['delete', 'id' => $tag->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $tag->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $tag->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($tag->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $tag->id], ['data-ajax' => '', 'class' => 'button '.($tag->active ? 'published' : 'draft')]); ?>
                    <?php echo Html::endForm(); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
