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
 * @package blackcube\admin\views\user
 *
 * @var $usersQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;


$formatter = Yii::$app->formatter;
?>
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
                        <?php foreach ($usersQuery->each() as $user): ?>
                        <tr>
                            <td>
                                <div class="flex items-center">
                                    <p class="text-gray-900 whitespace-no-wrap">
                                        <?php if (Yii::$app->user->can(Rbac::PERMISSION_USER_UPDATE)): ?>
                                        <?php echo Html::a($user->email, ['edit', 'id' => $user->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                                        <?php else: ?>
                                            <?php echo Html::tag('span', $user->email, ['class' => 'py-1']); ?>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </td>
                            <td>
                                <?php if (Yii::$app->user->can(Rbac::PERMISSION_USER_DELETE)): ?>
                                <?php echo Html::beginForm(['delete', 'id' => $user->id], 'post', ['data-ajax-modal' => Url::to(['modal', 'id' => $user->id])]); ?>
                                    <button class="button danger">
                                        <i class="fa fa-trash-alt"></i>
                                    </button>
                                <?php endif; ?>
                                <?php if (Yii::$app->user->can(Rbac::PERMISSION_USER_UPDATE)): ?>
                                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $user->id], ['class' => 'button']); ?>
                                <?php echo Html::a(($user->active?'<i class="fa fa-eye"></i>':' <i class="fa fa-eye-slash"></i>'), ['toggle', 'id' => $user->id], ['data-ajax' => '', 'class' => 'button '.($user->active ? 'published' : 'draft')]); ?>
                                <?php endif; ?>
                                <?php if (Yii::$app->user->can(Rbac::PERMISSION_USER_DELETE)): ?>
                                <?php echo Html::endForm(); ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
