<?php
/**
 * form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\form
 *
 * @var $element Slug
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\models\Administrator;
use blackcube\admin\helpers\Html;
use blackcube\core\models\Slug;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;
use yii\helpers\ArrayHelper;
use blackcube\core\models\Parameter;
use blackcube\admin\helpers\Aurelia;
use yii\helpers\Url;
use yii\web\Response;
?>
<main class="application-content">
    <?php echo Html::beginForm('', 'post', [
        'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">
        <?php echo Html::beginTag('a', [
            'class' => 'text-white',
            'href' => Url::to(['index'])
        ]); ?>
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-7 w-7']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('slug', 'Slug'); ?></h3>
    </div>
    <div class="px-6 pb-6">
        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($element, 'active', []); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($element, 'host', ArrayHelper::map(Parameter::getAllowedHosts(), 'id', 'value'), []); ?>
                </div>
                <div class="element-form-bloc-cols-9">
                    <?php echo BlackcubeHtml::activeTextInput($element, 'path', []); ?>
                </div>
                <!-- div class="element-form-bloc-cols-1 flex items-end">
                <?php echo Html::a(Heroicons::svg('solid/refresh', ['class' => 'h-4 w-4']), '', [
                    'class' => 'relative inline-flex items-center p-2.5 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:text-white hover:bg-indigo-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500',
                    'blackcube-url-generator' => Url::toRoute('ajax/generate-slug')
                ]); ?>
            </div -->
            </div>
            <?php // 'httpCode', 'path', 'host', 'targetUrl', 'active' ?>
            <?php if ($element->scenario === Slug::SCENARIO_REDIRECT):?>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($element, 'httpCode', [
                        '300' => '(300) '.Response::$httpStatuses[300],
                        '301' => '(301) '.Response::$httpStatuses[301],
                        '302' => '(302) '.Response::$httpStatuses[302],
                        '303' => '(303) '.Response::$httpStatuses[303],
                        '305' => '(305) '.Response::$httpStatuses[305],
                        '307' => '(307) '.Response::$httpStatuses[307],
                        '308' => '(308) '.Response::$httpStatuses[308],
                    ], []); ?>
                </div>
                <div class="element-form-bloc-cols-9">
                    <?php echo BlackcubeHtml::activeTextInput($element, 'targetUrl', []); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="px-6 pb-6">
        <div class="element-form-buttons">
            <?php echo Html::beginTag('a', [
                'class' => 'element-form-buttons-button',
                'href' => Url::to(['index'])
            ]); ?>
            <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Cancel'); ?>
            <?php echo Html::endTag('a'); ?>
            <?php echo Html::beginTag('button', [
                'class' => 'element-form-buttons-button action',
                'type' => 'submit'
            ]); ?>
            <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Save'); ?>
            <?php echo Html::endTag('button'); ?>
        </div>
    </div>
</main>

