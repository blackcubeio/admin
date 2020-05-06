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
 * @package blackcube\admin\views\menu
 *
 * @var $menu \blackcube\core\models\Menu
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
                            <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_UPDATE)): ?>
                                <?php echo Html::a($menu->name, ['edit', 'id' => $menu->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                            <?php else: ?>
                                <?php echo Html::tag('span', $menu->name, ['class' => 'py-1']); ?>
                            <?php endif; ?>
                            <span class="text-xs text-gray-600 italic">#<?php echo $menu->id; ?></span>
                            <span class="text-xs text-gray-600 italic">(<?php echo $menu->language->id; ?>)</span>
                        </div>
                    </div>
                </td>
                <td>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_DELETE)): ?>
                    <?php echo Html::beginForm(['delete', 'id' => $menu->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $menu->id])]); ?>
                        <button class="button danger">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_UPDATE)): ?>
                    <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $menu->id], ['class' => 'button']); ?>
                    <?php echo Html::a(($menu->active?'<i class="fa fa-play"></i>':' <i class="fa fa-pause"></i>'), ['toggle', 'id' => $menu->id], [
                            'data-ajaxify-source' => 'menu-toggle-active-'.$menu->id,
                            'class' => 'button '.($menu->active ? 'published' : 'draft')
                        ]); ?>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_DELETE)): ?>
                    <?php echo Html::endForm(); ?>
                    <?php endif; ?>
                </td>
