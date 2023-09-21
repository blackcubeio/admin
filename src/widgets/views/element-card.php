<?php
/**
 * element-card.php
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
 * @var $name string
 * @var $type string
 * @var $icon string
 * @var $controller string
 * @var $updatePermission string
 * @var $deletePermission string
 * @var $element \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag|\blackcube\core\models\Slug
 * @var $tree bool
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

$wrapperOptions = [
    'class' => 'card-wrapper'
];
if ($tree && $element instanceof Node) {
    $level = ($element->level - 1) * 8;
    $wrapperOptions['class'] .= ' ml-'.$level;
    // "ml-8 ml-16 ml-24 ml-32 ml-40 ml-48"
}
?>
<div class="card">
    <?php echo Html::beginTag('div', $wrapperOptions); ?>
        <div class="card-title-block">
            <?php if(Yii::$app->user->can($updatePermission)): ?>
                <?php echo Html::a($name . ' '. Html::tag('span', '(#'.$element->id.')', ['class' => 'card-title-id']), [$controller.'/edit', 'id' => $element->id], ['class' => 'card-title']); ?>
            <?php else: ?>
                <?php echo Html::tag('span', $name . ' '. Html::tag('span', '(#'.$element->id.')', ['class' => 'card-title-id']), ['class' => 'card-title']); ?>
            <?php endif; ?>
            <?php if(($element instanceof Slug) && $element->element === null): ?>
            <?php else: ?>
            <div class="card-title-publication">
                <?php echo Publication::widget(['element' => $element]); ?>
            </div>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <div class="card-body-info-wrapper">
                <p class="card-body-info-type">
                    <?php echo Heroicons::svg($icon, ['class' => 'card-body-info-icon']); ?>
                    <?php echo $type; ?>
                </p>
                <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category || $element instanceof Tag): ?>
                    <?php if ($element->type !== null): ?>
                        <p class="card-body-info">
                            <?php echo Heroicons::svg('outline/template', ['class' => 'card-body-info-icon']); ?>
                            <?php echo $element->type->name; ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category): ?>
                    <p class="card-body-info">
                        <?php echo Heroicons::svg('outline/flag', ['class' => 'card-body-info-icon']); ?>
                        <?php echo $element->language->id; ?>
                    </p>
                <?php elseif ($element instanceof Tag): ?>
                    <p class="card-body-info">
                        <?php echo Heroicons::svg('outline/color-swatch', ['class' => 'card-body-info-icon']); ?>
                        <?php echo $element->category->name; ?>
                    </p>
                    <p class="card-body-info">
                        <?php echo Heroicons::svg('outline/flag', ['class' => 'card-body-info-icon']); ?>
                        <?php echo $element->category->language->id; ?>
                    </p>
                <?php elseif ($element instanceof Slug): ?>
                    <?php $subElement = $element->element; ?>
                    <?php if ($subElement instanceof Node || $subElement instanceof Composite || $subElement instanceof Category || $subElement instanceof Tag): ?>
                        <?php if ($subElement instanceof Node): ?>
                            <p class="card-body-info">
                                <?php echo Heroicons::svg('outline/folder', ['class' => 'card-body-info-icon']); ?>
                                <?php echo Module::t('slug', 'Node'); ?>
                            </p>
                        <?php elseif ($subElement instanceof Composite): ?>
                            <p class="card-body-info">
                                <?php echo Heroicons::svg('outline/document-text', ['class' => 'card-body-info-icon']); ?>
                                <?php echo Module::t('slug', 'Composite'); ?>
                            </p>
                        <?php elseif ($subElement instanceof Category): ?>
                            <p class="card-body-info">
                                <?php echo Heroicons::svg('outline/color-swatch', ['class' => 'card-body-info-icon']); ?>
                                <?php echo Module::t('slug', 'Category'); ?>
                            </p>
                        <?php elseif ($subElement instanceof Tag): ?>
                            <p class="card-body-info">
                                <?php echo Heroicons::svg('outline/tag', ['class' => 'card-body-info-icon']); ?>
                                <?php echo Module::t('slug', 'Tag'); ?>
                            </p>
                        <?php endif; ?>
                        <?php if ($subElement->type !== null): ?>
                            <p class="card-body-info">
                                <?php echo Heroicons::svg('outline/template', ['class' => 'card-body-info-icon']); ?>
                                <?php echo $subElement->type->name; ?>
                            </p>
                        <?php endif; ?>
                    <?php elseif($subElement === null): ?>
                        <p class="card-body-info">
                            <?php echo Heroicons::svg('outline/external-link', ['class' => 'card-body-url-icon']); ?>
                            <?php echo Module::t('widgets', 'Redirect {httpCode}', [
                                    'httpCode' => $element->httpCode
                            ]); ?>
                        </p>
                        <p class="card-body-info">
                            <?php echo Heroicons::svg('outline/globe', ['class' => 'card-body-url-icon']); ?>
                            <?php echo $element->targetUrl; ?>
                        </p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="card-body-actions-wrapper">
                <!-- This example requires Tailwind CSS v2.0+ -->
                <span class="card-body-actions">
                    <?php if (Yii::$app->user->can($deletePermission)): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to([$controller.'/delete', 'id' => $element->id]),
                            'class' => 'card-body-actions-button delete',
                            'data-alert-delete' => Url::to([$controller.'/modal', 'id' => $element->id]),
                            'data-alert-delete-method' => 'post',
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('common', 'Delete'); ?></span>
                            <?php echo Heroicons::svg('outline/trash', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can($updatePermission)): ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to([$controller.'/edit', 'id' => $element->id]), 'class' => 'card-body-actions-button']); ?>
                            <span class="sr-only"><?php echo Module::t('common', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to([$controller.'/toggle', 'id' => $element->id]),
                            'class' => 'card-body-actions-button'.($element->active ? ' active':' inactive'),
                            'data-ajaxify-source' => $element::getElementType().'-toggle-active-'.$element->id,
                        ]); ?>
                            <span class="sr-only"><?php echo Module::t('common', 'Activate'); ?></span>
                            <?php echo Heroicons::svg($element->active ? 'outline/play' : 'outline/pause', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php endif; ?>
                    <?php if (($element instanceof Node || $element instanceof Composite || $element instanceof Category) && $element->slug !== null): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to([$element->getRoute()]),
                            'class' => 'card-body-actions-button',
                            'target' => '_blank',
                        ]); ?>
                        <span class="sr-only"><?php echo Module::t('common', 'View'); ?></span>
                        <?php echo Heroicons::svg('outline/globe', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php elseif (($element instanceof Slug) && $element->active): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to([$element->getRoute()]),
                            'class' => 'card-body-actions-button',
                            'target' => '_blank',
                        ]); ?>
                        <span class="sr-only"><?php echo Module::t('common', 'View'); ?></span>
                        <?php echo Heroicons::svg('outline/globe', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('a'); ?>
                    <?php else: ?>
                        <?php echo Html::beginTag('span', [
                            'class' => 'card-body-actions-button disabled',
                        ]); ?>
                        <span class="sr-only"><?php echo Module::t('common', 'View'); ?></span>
                        <?php echo Heroicons::svg('outline/globe', ['class' => 'card-body-actions-button-icon']); ?>
                        <?php echo Html::endTag('span'); ?>
                    <?php endif; ?>
                    </span>

            </div>
        </div>
        <div class="card-body-url">
            <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category || $element instanceof Tag): ?>
                <?php if ($element->slug !== null): ?>
                    <?php echo Heroicons::svg('outline/link', ['class' => 'card-body-url-icon']); ?>
                    <?php echo $element->slug->path; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>