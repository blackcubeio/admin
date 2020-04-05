<?php
/**
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;

$formatter = Yii::$app->formatter;
?>
    <table>
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
            <?php foreach ($categoriesQuery->each() as $category): ?>
            <?php /* @var \blackcube\core\models\Category $category */ ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo Html::a($category->name, ['edit', 'id' => $category->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $category]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['delete', 'id' => $category->id], 'post', ['data-ajax-modal' => \yii\helpers\Url::to(['modal', 'id' => $category->id])]); ?>
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
