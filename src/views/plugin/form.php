<?php
/**
 * form.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\composite
 *
 * @var $plugin \blackcube\core\models\Plugin
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;
use blackcube\core\models\Tag;
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
        <h3 class="page-header-title"><?php echo Module::t('composite', 'Plugin'); ?></h3>
    </div>
    <div class="px-6 pb-6">

        <div class="element-form-bloc">
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeCheckbox($plugin, 'active', ['hint' => Module::t('plugin', 'Plugin status')]); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeCheckbox($plugin, 'registered', ['hint' => Module::t('plugin', 'Plugin registered')]); ?>
                </div>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-2">
                    <?php echo BlackcubeHtml::activeTextInput($plugin, 'id'); ?>
                </div>
                <div class="element-form-bloc-cols-5">
                    <?php echo BlackcubeHtml::activeTextInput($plugin, 'name'); ?>
                </div>
                <div class="element-form-bloc-cols-5">
                    <?php echo BlackcubeHtml::activeTextInput($plugin, 'version'); ?>
                </div>
            </div>
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
    <?php echo Html::endForm(); ?>
</main>
