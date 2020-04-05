<?php
/**
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="table-container" blackcube-attach-modal="">
            <table>
            <thead>
                <tr>
                    <th>
                        <?php echo Yii::t('blackcube.admin', 'Name'); ?>
                        <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                        placeholder="<?php echo Yii::t('blackcube.admin', 'Name'); ?>" -->
                    </th>
                    <th class="tools">
                        <?php echo Yii::t('blackcube.admin', 'Action'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($typesQuery->each() as $type): ?>
                <?php /* @var \blackcube\core\models\Type $type */ ?>
                <tr>
                    <td>
                        <div class="flex items-center">
                            <p class="text-gray-900 whitespace-no-wrap">
                                <?php echo Html::a($type->name, ['edit', 'id' => $type->id], ['class' => 'hover:text-blue-600 py-1']); ?>

                            </p>
                        </div>
                    </td>
                    <td>
                        <?php echo Html::beginForm(['delete', 'id' => $type->id], 'post', ['data-ajax-modal' => \yii\helpers\Url::to(['modal', 'id' => $type->id])]); ?>
                        <?php if ($type->getElementsCount() > 0): ?>
                            <span class="button disabled">
                                <i class="fa fa-trash-alt"></i>
                            </span>
                        <?php else: ?>
                            <button class="button danger">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        <?php endif; ?>
                        <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $type->id], ['class' => 'button']); ?>
                        <?php echo Html::endForm(); ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <div class="px-6 py-6 flex flex-col xs:flex-row items-center justify-end xs:justify-between">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Create'), ['create'], ['class' => 'text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded']); ?>
            </div>
        <?php /*
        <div
                class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                            <span class="text-xs xs:text-sm text-gray-900">
                                Showing 1 to 4 of 50 Entries
                            </span>
            <div class="inline-flex mt-2 xs:mt-0">
                <button
                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                    Prev
                </button>
                <button
                        class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                    Next
                </button>
            </div>
        </div>
        <?php */ ?>
        </div>
    </main>
</div>
