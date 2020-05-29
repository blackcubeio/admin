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
 * @package blackcube\admin\views\type
 *
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;

$pathAlias = Module::getInstance()->adminTemplatesAlias;
$formatter = Yii::$app->formatter;
?>
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
                    <div class="text-gray-900 whitespace-no-wrap">
                        <?php if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_UPDATE)): ?>
                            <?php echo Html::a($type->name, ['edit', 'id' => $type->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        <?php else: ?>
                            <?php echo Html::tag('span', $type->name, ['class' => 'py-1']); ?>
                        <?php endif; ?>
                        <span class="text-xs text-gray-600 italic">#<?php echo $type->id; ?></span>
                        <div>
                                <span class="text-xs text-gray-600  px-2 py-0 italic border bg-gray-100 border-gray-300 rounded">
                                    <?php echo Module::t('type', 'Route: {route}', ['route' => $type->route]); ?>
                                </span>
                        </div>

                    </div>
                </div>
            </td>
            <td>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_DELETE)): ?>
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
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_UPDATE)): ?>
                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $type->id], ['class' => 'button']); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_DELETE)): ?>
                <?php echo Html::endForm(); ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
