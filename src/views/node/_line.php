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
 * @package blackcube\admin\views\node
 *
 * @var $node \blackcube\core\models\Node
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
                <td>
                    <div class="flex items-start">
                        <?php //TODO: fix margin left (problem when level > 4) ?>
                        <?php echo Html::beginTag('p', ['class' => 'text-gray-900 whitespace-no-wrap '.('ml-'.(($node->level -1) * 4))]); ?>
                            <?php echo Html::a($node->name, ['edit', 'id' => $node->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <span class="text-xs text-gray-600 italic">(<?php echo $node->language->id; ?>)</span>
                            <?php if (($node->dateStart !== null) || ($node->dateEnd !== null)): ?>
                                <br/>
                                <span class="text-xs text-gray-600 italic ml-2">
                                <?php if ($node->dateStart !== null): ?>
                                        <?php echo Module::t('node', 'Start: {0,date,medium}', [$node->activeDateStart]); ?>

                                <?php endif; ?>
                                <?php if ($node->dateEnd !== null): ?>
                                        <?php echo Module::t('node', 'End: {0,date,medium}', [$node->activeDateEnd]); ?>
                                <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        <?php echo Html::endTag('p'); ?>
                    </div>
                </td>
                <td>
                    <?php if ($node->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $node->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('node', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $node]); ?>
                </td>
                <td>
                    <?php echo Html::beginForm(['delete', 'id' => $node->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $node->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $node->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($node->active?'<i class="fa fa-play"></i>':' <i class="fa fa-stop"></i>'), ['toggle', 'id' => $node->id], [
                        'data-ajaxify-source' => 'node-toggle-active-'.$node->id,
                        'class' => 'button '.($node->active ? 'published' : 'draft')]); ?>
                    <?php if ($node->slug !== null): ?>
                    <?php echo Html::a('<i class="fa fa-globe-americas"></i>', [$node->getRoute()], [
                        'class' => 'button',
                        'target' => '_blank',
                    ]); ?>
                    <?php else: ?>
                    <span class="button disabled"><i class="fa fa-globe-americas"></i></span>
                    <?php endif; ?>
                    <?php echo Html::endForm(); ?>
                </td>
