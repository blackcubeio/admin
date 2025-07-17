<?php
/**
 * form.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $language \blackcube\core\models\Language
 * @var $mainLanguagesQuery \blackcube\core\models\FilterActiveQuery
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
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-5 w-5 mr-2']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('language', 'Language'); ?></h3>
    </div>
    <div class="px-6 pb-6">

        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($language, 'active', ['hint' => Module::t('language', 'Language status')]); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-2">
                    <?php echo BlackcubeHtml::activeTextInput($language, 'id', []); ?>
                </div>
                <div class="element-form-bloc-cols-7">
                    <?php echo BlackcubeHtml::activeTextInput($language, 'name', []); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeCheckbox($language, 'main', [
                            'mainLabel' => Module::t('language', 'Language is primary')
                        ]); ?>
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
