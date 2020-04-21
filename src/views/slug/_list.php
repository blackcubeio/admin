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
 * @package blackcube\admin\views\slug
 *
 * @var $slugsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use blackcube\core\models\Node;
use blackcube\core\models\Composite;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('slug', 'Url'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('composite', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('slug', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('slug', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('slug', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($slugsQuery->each() as $slug): ?>
            <?php /* @var \blackcube\core\models\Slug $slug */ ?>
            <tr>
                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_UPDATE)): ?>
                                <?php echo Html::a($slug->path, ['edit', 'id' => $slug->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $slug->path, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php if ($slug->element instanceof Node): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('slug', 'Node'); ?></span>
                    <?php elseif ($slug->element instanceof Composite): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('slug', 'Composite'); ?></span>
                    <?php elseif ($slug->element instanceof Category): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('slug', 'Category'); ?></span>
                    <?php elseif ($slug->element instanceof Tag): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('slug', 'Tag'); ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('slug', 'Redirect'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($slug->element !== null): ?>
                        <?php echo Publication::widget(['element' => $slug->element]); ?>
                    <?php else: ?>
                        <?php echo Publication::widget(['element' => $slug]); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($slug->element === null && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_DELETE)): ?>
                        <?php echo Html::beginForm(['delete', 'id' => $slug->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $slug->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php else: ?>
                        <span class="button disabled"><i class="fa fa-trash-alt"></i></span>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_SLUG_UPDATE)): ?>
                        <?php /*/ ?>
                        <?php if ($slug->element instanceof Node && Yii::$app->user->can(Rbac::PERMISSION_NODE_UPDATE)): ?>
                            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['node/edit', 'id' => $slug->element->id], ['class' => 'button']); ?>
                        <?php elseif ($slug->element instanceof Composite && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_UPDATE)): ?>
                            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['composite/edit', 'id' => $slug->element->id], ['class' => 'button']); ?>
                        <?php elseif ($slug->element instanceof Category && Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_UPDATE)): ?>
                            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['category/edit', 'id' => $slug->element->id], ['class' => 'button']); ?>
                        <?php elseif ($slug->element instanceof Tag && Yii::$app->user->can(Rbac::PERMISSION_TAG_UPDATE)): ?>
                            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['tag/edit', 'id' => $slug->element->id], ['class' => 'button']); ?>
                        <?php else: ?>
                            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $slug->id], ['class' => 'button']); ?>
                        <?php endif; ?>
                        <?php /*/ ?>
                        <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $slug->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($slug->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $slug->id], ['data-ajax' => '', 'class' => 'button '.($slug->active ? 'published' : 'draft')]); ?>
                    <?php endif; ?>
                    <?php if ($slug->element === null && Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_DELETE)): ?>
                        <?php echo Html::endForm(); ?>
                    <?php endif; ?>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
