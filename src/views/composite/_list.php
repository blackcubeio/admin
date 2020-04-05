<?php
/**
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
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
            <?php foreach ($compositesQuery->each() as $composite): ?>
            <?php /* @var \blackcube\core\models\Composite $composite */ ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo Html::a($composite->name, ['edit', 'id' => $composite->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php if ($composite->dateStart !== null): ?>
                                <span class="text-xs text-gray-600 italic">Début: <?php echo $formatter->asDate($composite->dateStart); ?></span>
                            <?php endif; ?>
                            <?php if ($composite->dateEnd !== null): ?>
                                <span class="text-xs text-gray-600 italic">Fin: <?php echo $formatter->asDate($composite->dateEnd); ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $composite]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['delete', 'id' => $composite->id], 'post', ['data-ajax-modal' => \yii\helpers\Url::to(['modal', 'id' => $composite->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $composite->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($composite->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $composite->id], ['data-ajax' => '', 'class' => 'button '.($composite->active ? 'published' : 'draft')]); ?>
                    <?php echo Html::endForm(); ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
