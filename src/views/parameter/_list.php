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
 * @package blackcube\admin\views\parameter
 *
 * @var $parametersQuery \yii\db\ActiveQuery
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
                <?php echo Module::t('parameter', 'Name'); ?>
            </th>
            <th class="tools">
                <?php echo Module::t('parameter', 'Action'); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($parametersQuery->each() as $parameter): ?>
        <?php /* @var \blackcube\core\models\Parameter $parameter */ ?>
        <tr>
            <td>
                <div class="flex items-center">
                    <p class="text-gray-900 whitespace-no-wrap">
                        <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_UPDATE)): ?>
                        <?php echo Html::beginTag('a', ['href' =>Url::to(['edit', 'domain' => $parameter->domain, 'name' => $parameter->name]), 'class' => 'hover:text-blue-600 py-1']); ?>
                            <span><?php echo $parameter->domain; ?><i class="fa fa-caret-right px-2"></i><?php echo $parameter->name; ?></span>
                        <?php echo Html::endTag('a'); ?>
                        <?php else: ?>
                            <span class="py-1"><?php echo $parameter->domain; ?><i class="fa fa-caret-right px-2"></i><?php echo $parameter->name; ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </td>
            <td>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_DELETE)): ?>
                <?php echo Html::beginForm(['delete', 'domain' => $parameter->domain, 'name' => $parameter->name], 'post', ['data-ajax-modal' => Url::to(['modal', 'domain' => $parameter->domain, 'name' => $parameter->name])]); ?>
                    <button class="button danger">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_UPDATE)): ?>
                <?php echo Html::a('<i class="fa fa-pen-alt"></i>', ['edit', 'domain' => $parameter->domain, 'name' => $parameter->name], ['class' => 'button']); ?>
                <?php endif; ?>
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_DELETE)): ?>
                <?php echo Html::endForm(); ?>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
