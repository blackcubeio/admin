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
 * @package blackcube\admin\views\bloc-type
 *
 * @var $blocTypesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
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
        <div class="table-container">
            <div blackcube-ajax-link="" blackcube-attach-modal="">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <?php echo Module::t('bloc-type', 'Name'); ?>
                            </th>
                            <th class="tools">
                                <?php echo Module::t('bloc-type', 'Action'); ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($blocTypesQuery->each() as $blocType): ?>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        <?php echo Html::a($blocType->name, ['edit', 'id' => $blocType->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <?php echo Html::beginForm(['delete', 'id' => $blocType->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $blocType->id])]); ?>
                                <?php if ($blocType->getBlocs()->count() > 0): ?>
                                    <span class="button disabled">
                                        <i class="fa fa-trash-alt"></i>
                                    </span>
                                <?php else: ?>
                                    <button class="button danger">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $blocType->id], ['class' => 'button']); ?>
                                <?php echo Html::endForm(); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('bloc-type', 'Create'), ['create'], ['class' => 'button-submit']); ?>
            </div>
        </div>
    </main>
</div>
