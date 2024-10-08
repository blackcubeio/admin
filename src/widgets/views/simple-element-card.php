<?php
/**
 * simple-element-card.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\dashboard
 *
 * @var $title string
 * @var $info string
 * @var $type string
 * @var $icon string
 * @var $controller string
 * @var $updatePermission string
 * @var $deletePermission string
 * @var $element \blackcube\admin\models\Administrator
 * @var $elementType string
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use blackcube\admin\Module;
use blackcube\admin\helpers\Heroicons;
use blackcube\core\models\Language;
use blackcube\core\models\Parameter;
use blackcube\admin\models\Administrator;
use blackcube\core\models\Menu;

$wrapperOptions = [
    'class' => 'card-wrapper'
];

if ($element instanceof Parameter) {
    $routeParameters = [
        'name' => $element->name,
        'domain' => $element->domain,
    ];
    $displayId = null;
} else {
    $routeParameters = [
        'id' => $element->id,
    ];
    $displayId = $element->id;;
}
?>
<div class="card">
    <?php echo Html::beginTag('div', $wrapperOptions); ?>
    <div class="card-title-block">
        <?php if(Yii::$app->user->can($updatePermission)): ?>
            <?php echo Html::a($title . (($displayId !== null)?' '. Html::tag('span', '(#'.$displayId.')', ['class' => 'card-title-id']) : ''), [$controller.'/edit'] + $routeParameters, ['class' => 'card-title']); ?>
        <?php else: ?>
            <?php echo Html::tag('span', $title .(($displayId !== null)?' '. Html::tag('span', '(#'.$displayId.')', ['class' => 'card-title-id']) : ''), ['class' => 'card-title']); ?>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <div class="card-body-info-wrapper">
            <?php if($element instanceof Menu): ?>
                <p class="card-body-info-type">
                    <?php echo Heroicons::svg('outline/flag', ['class' => 'card-body-info-icon']); ?>
                    <?php echo $element->language->id; ?>
                </p>
                <?php if (empty($element->host) === false): ?>
                    <p class="card-body-info">
                        <?php echo Heroicons::svg('outline/globe', ['class' => 'card-body-info-icon']); ?>
                        <?php echo $element->host; ?>
                    </p>
                <?php endif; ?>
            <?php else: ?>
                <p class="card-body-info-type">
                    <?php echo $info; ?>
                </p>
            <?php endif; ?>
        </div>
        <div class="card-body-actions-wrapper">
            <!-- This example requires Tailwind CSS v2.0+ -->
            <span class="card-body-actions">
                    <?php if (Yii::$app->user->can($deletePermission)): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to([$controller.'/delete'] + $routeParameters),
                            'class' => 'card-body-actions-button delete',
                            'data-alert-delete' => Url::to([$controller.'/modal'] + $routeParameters),
                            'data-alert-delete-method' => 'post',
                        ]); ?>
                        <span class="sr-only"><?php echo Module::t('common', 'Delete'); ?></span>
                        <?php echo Heroicons::svg('outline/trash', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php endif; ?>
                <?php if (Yii::$app->user->can($updatePermission)): ?>
                    <?php echo Html::beginTag('a', ['href' => Url::to([$controller.'/edit'] + $routeParameters), 'class' => 'card-body-actions-button']); ?>
                    <span class="sr-only"><?php echo Module::t('common', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php if($element instanceof Administrator || $element instanceof Menu || $element instanceof Language): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to([$controller.'/toggle'] + $routeParameters),
                            'class' => 'card-body-actions-button'.($element->active ? ' active':' inactive'),
                            'data-ajaxify-source' => $elementType.'-toggle-active-'.$element->id,
                        ]); ?>
                        <span class="sr-only"><?php echo Module::t('common', 'Activate'); ?></span>
                        <?php echo Heroicons::svg($element->active ? 'outline/play' : 'outline/pause', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php endif; ?>
                <?php endif; ?>
                </span>

        </div>
    </div>
</div>
</div>