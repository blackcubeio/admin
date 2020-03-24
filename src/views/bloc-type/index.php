<?php
/**
 * @var $blocTypesQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1" loader-done="">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="bg-white flex-1 p-3 overflow-hidden">
        <div class="inline-block min-w-full overflow-hidden px-6 py-6">
            <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Name'); ?>
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'View'); ?>
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Created at'); ?>
                    </th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                        <?php echo Yii::t('blackcube.admin', 'Action'); ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($blocTypesQuery->each() as $blocType): ?>
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <div class="flex items-center">
                            <div class="ml-3">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    <?php echo Html::a($blocType->name, ['bloc-type/edit', 'id' => $blocType->id], ['class' => 'hover:text-blue-600 py-1 px-4']); ?>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap"><?php echo $blocType->view; ?></p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php echo $formatter->asDate($blocType->dateCreate); ?>
                        </p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <?php if ($blocType->getBlocs()->count() > 0): ?>
                            <span class="bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center opacity-25">
                                <i class="fa fa-trash-alt"></i>
                            </span>
                        <?php else: ?>
                            <?php echo Html::beginForm(['bloc-type/delete', 'id' => $blocType->id]); ?>
                            <button class="bg-gray-300 hover:bg-red-600 hover:text-white text-gray-800 font-bold py-2 px-4 rounded inline-flex items-center">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                            <?php echo Html::endForm(); ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
            <div class="px-6 py-6 flex flex-col xs:flex-row items-center justify-end xs:justify-between">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Create'), ['bloc-type/create'], ['class' => 'text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded']); ?>
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
