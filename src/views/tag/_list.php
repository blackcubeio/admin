<?php
/**
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Yii::t('blackcube.admin', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Yii::t('blackcube.admin', 'Name'); ?>" -->
                </th>
                <th class="status">
                    <?php echo Yii::t('blackcube.admin', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Yii::t('blackcube.admin', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tagsQuery->each() as $tag): ?>
            <?php /* @var \blackcube\core\models\Tag $tag */ ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo Html::a($tag->name, ['tag/edit', 'id' => $tag->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <span class="text-xs text-gray-600 italic">(<?php echo Html::a($tag->category->name, ['category/index', 'id' => $tag->categoryId], ['class' => 'hover:text-blue-600 py-1']); ?>)</span>
                        </p>
                    </div>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $tag]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['tag/delete', 'id' => $tag->id], 'post', ['data-ajax-modal' => \yii\helpers\Url::to(['tag/modal', 'id' => $tag->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['tag/edit', 'id' => $tag->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($tag->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['tag/toggle', 'id' => $tag->id], ['data-ajax' => '', 'class' => 'button '.($tag->active ? 'published' : 'draft')]); ?>
                    <?php echo Html::endForm(); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
