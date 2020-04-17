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
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
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
        <?php foreach ($blocTypesQuery->each() as $blocType): ?>
        <tr>
            <td>
                <div class="flex items-center">
                    <p class="text-gray-900 whitespace-no-wrap">
                        <?php if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_UPDATE)): ?>
                            <?php echo Html::a($blocType->name, ['edit', 'id' => $blocType->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        <?php else: ?>
                            <?php echo Html::tag('span', $blocType->name, ['class' => 'py-1']); ?>
                        <?php endif; ?>
                    </p>
                </div>
            </td>
            <td>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_DELETE)): ?>
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
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_UPDATE)): ?>
                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'id' => $blocType->id], ['class' => 'button']); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_DELETE)): ?>
                <?php echo Html::endForm(); ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
