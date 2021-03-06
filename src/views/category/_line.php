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
 * @package blackcube\admin\views\category
 *
 * @var $category \blackcube\core\models\Category
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
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_UPDATE)): ?>
                                <?php echo Html::a($category->name, ['edit', 'id' => $category->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $category->name, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                            <span class="text-xs text-gray-600 italic">#<?php echo $category->id; ?></span>
                            <span class="text-xs text-gray-600 italic">(<?php echo $category->language->id; ?>)</span>
                            <?php if ($category->slug !== null): ?>
                                <div>
                                    <span class="text-xs text-gray-600  px-2 py-0 italic border bg-gray-100 border-gray-300 rounded">
                                        <?php echo $category->slug->path; ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if ($category->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $category->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('category', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $category]); ?>
                </td>
                <td>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_DELETE)): ?>
                    <?php echo Html::beginForm(['delete', 'id' => $category->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $category->id])]); ?>
                    <?php if ($category->getTags()->count() > 0): ?>
                        <span class="button disabled">
                            <i class="fa fa-trash-alt"></i>
                        </span>
                    <?php else: ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_UPDATE)): ?>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $category->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($category->active?'<i class="fa fa-play"></i>':' <i class="fa fa-pause"></i>'), ['toggle', 'id' => $category->id], [
                            'data-ajaxify-source' => 'category-toggle-active-'.$category->id,
                            'class' => 'button '.($category->active ? 'published' : 'draft')]); ?>
                    <?php endif; ?>
                    <?php if ($category->slug !== null): ?>
                        <?php echo Html::a('<i class="fa fa-globe-americas"></i>', [$category->getRoute()], [
                            'class' => 'button',
                            'target' => '_blank',
                        ]); ?>
                    <?php else: ?>
                        <span class="button disabled"><i class="fa fa-globe-americas"></i></span>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_DELETE)): ?>
                    <?php echo Html::endForm(); ?>
                    <?php endif; ?>
                </td>
