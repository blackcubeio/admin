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
 * @package blackcube\admin\views\composite
 *
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('composite', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('composite', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('composite', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('composite', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('composite', 'Action'); ?>
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
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_UPDATE)): ?>
                            <?php echo Html::a($composite->name, ['edit', 'id' => $composite->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $composite->name, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                            <span class="text-xs text-gray-600 italic">(<?php echo $composite->language->id; ?>)</span>
                            <?php if (($composite->dateStart !== null) || ($composite->dateEnd !== null)): ?>
                                <br/>
                                <span class="text-xs text-gray-600 italic ml-2">
                                <?php if ($composite->dateStart !== null): ?>
                                        <?php echo Module::t('composite', 'Start: {0,date,medium}', [$composite->activeDateStart]); ?>

                                <?php endif; ?>
                                <?php if ($composite->dateEnd !== null): ?>
                                        <?php echo Module::t('composite', 'End: {0,date,medium}', [$composite->activeDateEnd]); ?>
                                <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php if ($composite->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $composite->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('composite', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $composite]); ?>
                </td>
                <td>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_DELETE)): ?>
                    <?php echo Html::beginForm(['delete', 'id' => $composite->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $composite->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_UPDATE)): ?>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $composite->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($composite->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $composite->id], ['data-ajax' => '', 'class' => 'button '.($composite->active ? 'published' : 'draft')]); ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_DELETE)): ?>
                    <?php echo Html::endForm(); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
