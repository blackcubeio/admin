<?php
/**
 * _tags.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $element \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag
 * @var $formElements array
 * @var $selectedTags array
 * @var $saved bool|null
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

$additionalOptions = [];
if ($saved === true) {
    $additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
        'title.bind' => Module::t('common', 'Success'),
        'type.bind' => 'check',
        'content.bind' => Module::t('common', 'Tags were saved'),
    ]);
    $additionalOptions['blackcube-overlay-close'] = '';
} elseif ($saved === false) {
    $additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
        'title.bind' => Module::t('common', 'Error'),
        'type.bind' => 'exclamation',
        'content.bind' => Module::t('common', 'Tags were not saved'),
    ]);
}
?>

<?php echo Html::beginTag('div', [
    'class' => 'bg-indigo-800 py-6 px-4 sm:px-6'
] + $additionalOptions); ?>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-white" id="slide-over-title"><?php echo Module::t('common', 'Tags management'); ?></h2>
        <div class="ml-3 flex h-7 items-center">
            <button type="button" data-overlay-action="close" class="rounded-md bg-indigo-800 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                <span class="sr-only"><?php echo Module::t('common', 'Close panel'); ?></span>
                <?php echo Heroicons::svg('outline/x', ['class' => 'h-6 w-6']); ?>
            </button>
        </div>
    </div>
    <div class="mt-1">
        <p class="text-sm text-indigo-300">
            <?php echo Module::t('common', 'Tags are used to filter elements'); ?>
        </p>
    </div>
<?php echo Html::endTag('div'); ?>
<div class="relative flex-1 py-6 px-4 sm:px-6">
    <!-- Replace with your content -->
    <?php echo Html::beginForm(['tag', 'id' => $element->id]); ?>
        <?php $index = 0; ?>
        <?php foreach($formElements as $formElement): ?>
        <div class="element-form-bloc">
            <div class="element-form-bloc-wrapper pb-2">
                <h3 class="element-form-bloc-title">
                    <?php echo $formElement['category']->name; ?>
                </h3>
                <div class="element-form-bloc-inner">
                <?php foreach($formElement['tags'] as $tag): ?>
                    <div class="element-form-bloc-stacked">
                        <?php echo BlackcubeHtml::activeCheckbox($tag, '['.($index++).']checked', [
                            'label' => $tag->name,
                        ]); ?>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

    <div class="element-form-buttons">
        <?php echo Html::beginTag('button', [
            'type' => 'button',
            'class' => 'element-form-buttons-button',
            'data-overlay-action' => 'close',
        ]); ?>
        <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
        <?php echo Module::t('common', 'Cancel'); ?>
        <?php echo Html::endTag('button'); ?>


        <?php echo Html::beginTag('button', [
            'class' => 'element-form-buttons-button action',
            'type' => 'submit'
        ]); ?>
        <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
        <?php echo Module::t('common', 'Save'); ?>
        <?php echo Html::endTag('button'); ?>
    </div>
    <?php echo Html::endForm(); ?>
    <!-- /End replace -->
</div>
