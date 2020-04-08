<?php
/**
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="table-container" >
            <div blackcube-ajax-link="" blackcube-attach-modal="">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <?php echo Module::t('type', 'Name'); ?>
                            </th>
                            <th class="tools">
                                <?php echo Module::t('type', 'Action'); ?>
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
                                <?php echo Html::beginForm(['delete', 'id' => $type->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $type->id])]); ?>
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
            </div>
            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('type', 'Create'), ['create'], ['class' => 'button-submit']); ?>
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
