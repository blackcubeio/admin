<?php
/**
 * _line.php
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
 * @var $composite \blackcube\core\models\Composite
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
                <td>
                    <div class="flex items-start">
                        <div class="text-gray-900 whitespace-no-wrap">
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_UPDATE)): ?>
                            <?php echo Html::a($composite->name, ['edit', 'id' => $composite->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $composite->name, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                            <span class="text-xs text-gray-600 italic">#<?php echo $composite->id; ?></span>
                            <span class="text-xs text-gray-600 italic">(<?php echo $composite->language->id; ?>)</span>
                            <?php if ($composite->slug !== null): ?>
                                <div>
                                        <span class="text-xs text-gray-600  px-2 py-0 italic border bg-gray-100 border-gray-300 rounded">
                                            <?php echo $composite->slug->path; ?>
                                        </span>
                                </div>
                            <?php endif; ?>
                            <?php if (($composite->dateStart !== null) || ($composite->dateEnd !== null)): ?>
                                <div>
                                <span class="text-xs text-gray-600 italic ml-2">
                                <?php if ($composite->dateStart !== null): ?>
                                        <?php echo Module::t('composite', 'Start: {0,date,medium}', [$composite->activeDateStart]); ?>

                                <?php endif; ?>
                                <?php if ($composite->dateEnd !== null): ?>
                                        <?php echo Module::t('composite', 'End: {0,date,medium}', [$composite->activeDateEnd]); ?>
                                <?php endif; ?>
                                </span>
                                </div>
                            <?php endif; ?>
                        </div>
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
                    <?php echo Html::a(($composite->active?'<i class="fa fa-play"></i>':' <i class="fa fa-pause"></i>'), ['toggle', 'id' => $composite->id], [
                            'data-ajaxify-source' => 'composite-toggle-active-'.$composite->id,
                            'class' => 'button '.($composite->active ? 'published' : 'draft')]); ?>
                    <?php endif; ?>
                    <?php if ($composite->slug !== null): ?>
                        <?php echo Html::a('<i class="fa fa-globe-americas"></i>', [$composite->getRoute()], [
                            'class' => 'button',
                            'target' => '_blank',
                        ]); ?>
                    <?php else: ?>
                        <span class="button disabled"><i class="fa fa-globe-americas"></i></span>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_DELETE)): ?>
                    <?php echo Html::endForm(); ?>
                    <?php endif; ?>
                </td>
