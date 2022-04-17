<?php
/**
 * menu-item-card.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\dashboard
 *
 * @var $menuItem \blackcube\core\models\MenuItem
 * @var $level int
 * @var $type string
 * @var $name string
 * @var $icon string
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;
use blackcube\core\models\Node;
use blackcube\core\models\Composite;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use blackcube\core\models\Slug;
use blackcube\admin\widgets\Publication;
use blackcube\admin\components\Rbac;
use blackcube\core\models\MenuItem;
use DateTime;
use Yii;

$wrapperOptions = [
    'class' => 'card-wrapper'
];

$wrapperOptions['class'] .= ' ml-'.($level * 4);
// "ml-8 ml-16 ml-24 ml-32 ml-40 ml-48"

?>
<div class="card">
    <?php echo Html::beginTag('div', $wrapperOptions); ?>
        <div class="card-title-block">
            <?php if(Yii::$app->user->can(Rbac::PERMISSION_MENU_UPDATE)): ?>
                <?php echo Html::a($menuItem->name . ' '. Html::tag('span', '(#'.$menuItem->id.')', ['class' => 'card-title-id']), ['edit-item', 'id' => $menuItem->id], ['class' => 'card-title']); ?>
            <?php else: ?>
                <?php echo Html::tag('span', $menuItem->name . ' '. Html::tag('span', '(#'.$menuItem->id.')', ['class' => 'card-title-id']), ['class' => 'card-title']); ?>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="card-body-info-wrapper">
                <p class="card-body-info-type">
                    <?php echo Heroicons::svg($icon, ['class' => 'card-body-info-icon']); ?>
                    <?php echo $type; ?>
                </p>
                <p class="card-body-info">
                    <?php echo Heroicons::svg('outline/lightning-bolt', ['class' => 'card-body-info-icon']); ?>
                    <?php echo $name; ?>
                </p>
            </div>
            <div class="card-body-actions-wrapper">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <span class="card-body-actions">
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_DELETE)): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['menu/delete-item', 'id' => $menuItem->id]),
                            'class' => 'card-body-actions-button delete',
                            'data-alert-delete' => Url::to(['menu/item-modal', 'id' => $menuItem->id]),
                            'data-alert-delete-method' => 'post',
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('common', 'Delete'); ?></span>
                            <?php echo Heroicons::svg('outline/trash', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can(Rbac::PERMISSION_MENU_UPDATE)): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['edit-item', 'id' => $menuItem->id]), 'class' => 'card-body-actions-button']); ?>
                            <span class="sr-only"><?php echo Module::t('common', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php if ($menuItem->order > 1): ?>
                            <?php echo Html::beginTag('a', [
                                'href' => Url::to(['up-item', 'id' => $menuItem->id]),
                                'class' => 'card-body-actions-button',
                                'data-ajaxify-source' => 'refresh-menu-items'
                            ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Up'); ?></span>
                            <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('a'); ?>
                        <?php else: ?>
                            <?php echo Html::beginTag('span', [
                                'class' => 'card-body-actions-button disabled'
                            ]); ?>
                            <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('span'); ?>
                        <?php endif; ?>
                        <?php $itemCount = MenuItem::find()->andWhere(['menuId' => $menuItem->menuId, 'parentId' => $menuItem->parentId])->count(); ?>
                        <?php if ($menuItem->order < $itemCount): ?>
                            <?php echo Html::beginTag('a', [
                                'href' => Url::to(['down-item', 'id' => $menuItem->id]),
                                'class' => 'card-body-actions-button',
                                'data-ajaxify-source' => 'refresh-menu-items'
                            ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Down'); ?></span>
                            <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('a'); ?>
                        <?php else: ?>
                            <?php echo Html::beginTag('span', [
                                'class' => 'card-body-actions-button disabled'
                            ]); ?>
                            <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('span'); ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    </span>

            </div>
        </div>
    </div>
</div>