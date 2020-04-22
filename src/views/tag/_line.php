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
 * @package blackcube\admin\views\tag
 *
 * @var $tag \blackcube\core\models\Tag
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$currentCategoryId = null;
?>

                <td>
                    <div class="flex items-start">
                        <p class="text-gray-900 whitespace-no-wrap">
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_UPDATE)): ?>
                                <?php echo Html::a($tag->name, ['edit', 'id' => $tag->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $tag->name, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </td>
                <td>
                    <?php if ($tag->type !== null): ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo $tag->type->name; ?></span>
                    <?php else: ?>
                        <span class="text-xs text-gray-600 italic uppercase"><?php echo Module::t('tag', 'No type'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo Publication::widget(['element' => $tag]); ?>
                </td>
                <td>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_DELETE)): ?>
                    <?php echo Html::beginForm(['delete', 'id' => $tag->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $tag->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_UPDATE)): ?>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $tag->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($tag->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $tag->id], [
                            'data-ajaxify-source' => 'tag-toggle-active-'.$tag->id,
                            'class' => 'button '.($tag->active ? 'published' : 'draft')
                        ]); ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_DELETE)): ?>
                    <?php echo Html::endForm(); ?>
                    <?php endif; ?>
                </td>