<?php
/**
 * dashboard-card.php
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
 * @var $title string
 * @var $icon string
 * @var $listTitle string
 * @var $viewPermission string
 * @var $updatePermission string
 * @var $updateRoute string
 * @var $counts array
 * @var $elementsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;
use DateTime;
use Yii;

$formatter = Yii::$app->formatter;
?>
<div class="dashboard-card">
    <div class="dashboard-card-wrapper">
        <div class="dashboard-card-container">
            <div class="flex-shrink-0">
                <span class="p-2 block rounded-full text-indigo-800 bg-white">
                <?php echo Heroicons::svg($icon, ['class' => 'dashboard-card-icon']); ?>
                    </span>
            </div>
            <div class="ml-5 w-0 flex-1">
                <dl>
                    <dt class="text-lg font-bold text-white truncate">
                        <?php echo $title; ?>
                    </dt>
                    <dd class="py-2">
                        <span class="dashboard-card-badge active">
                            <?php echo Heroicons::svg('outline/sun', ['class' => 'dashboard-card-badge-icon']); ?>
                            <?php echo $counts['active']; ?>
                        </span>
                        <span class="dashboard-card-badge inactive">
                            <?php echo Heroicons::svg('outline/moon', ['class' => 'dashboard-card-badge-icon']); ?>
                            <?php echo $counts['global'] - $counts['active']; ?>
                        </span>
                        <span class="dashboard-card-badge slug">
                            <?php echo Heroicons::svg('outline/link', ['class' => 'dashboard-card-badge-icon']); ?>
                            <?php echo $counts['activeWithSlug']; ?>
                        </span>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="dashboard-card-list-wrapper">
        <div class="dashboard-card-list-heading">
            <?php echo $listTitle; ?>
        </div>
        <ul role="list" class="dashboard-card-list">
            <?php foreach($elementsQuery->each() as $element): ?>
                <?php /* @var $element \blackcube\core\components\Element */ ?>
                <li>
                    <?php if (Yii::$app->user->can($updatePermission) === true): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to([$updateRoute, 'id' => $element->id]),
                            'class' => 'item-link',
                        ]); ?>
                    <?php else: ?>
                        <span class="item-link">
                    <?php endif; ?>
                    <div class="item-content">
                        <div class="item-content-wrapper">
                            <div class="truncate">
                                <div class="flex text-sm">
                                    <p class="item-title">
                                        <?php echo $element->name; ?>
                                    </p>
                                    <p class="item-id">
                                        #<?php echo $element->id; ?>
                                    </p>
                                </div>
                                <div class="mt-2 flex">
                                    <div class="item-infos">
                                        <?php echo Heroicons::svg('outline/calendar', ['class' => 'item-infos-icon']); ?>
                                        <p>
                                            <!-- space -->
                                            <?php echo Html::tag('time',  $formatter->asRelativeTime(new DateTime($element->dateUpdate)), [
                                                'datetime' => $formatter->asDate(new DateTime($element->dateUpdate), 'yyyy-MM-dd'),
                                            ]); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (Yii::$app->user->can($updatePermission) === true): ?>
                        <div class="item-accessory">
                            <?php echo Heroicons::svg('outline/chevron-right', ['class' => 'item-accessory-icon']); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (Yii::$app->user->can($updatePermission) === true): ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php else: ?>
                        <span class="item-link">
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <!-- div class="bg-gray-50 px-5 py-3">
        <div class="text-sm">
            <a href="#" class="font-medium text-cyan-700 hover:text-cyan-900">
                View all
            </a>
        </div>
    </div -->
</div>
