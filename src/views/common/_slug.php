<?php
/**
 * _slug.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\common
 *
 * @var $element \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag
 * @var $slug Slug
 * @var $standalone bool
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
        'content.bind' => Module::t('common', 'Slug was saved'),
    ]);
    $additionalOptions['blackcube-broadcast-element'] = Aurelia::bindOptions([
        'events.bind' => ['update', ($slug->active?'activate': 'deactivate')],
        'type.bind' => Slug::getElementType(),
        'id.bind' => $slug->id,
    ]);
    $additionalOptions['blackcube-overlay-close'] = '';
} elseif ($saved === false) {
    $additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
        'title.bind' => Module::t('common', 'Error'),
        'type.bind' => 'exclamation',
        'content.bind' => Module::t('common', 'Slug was not saved'),
    ]);
}
?>

<?php echo Html::beginTag('div', [
    'class' => 'bg-indigo-800 py-6 px-4 sm:px-6'
] + $additionalOptions); ?>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-white" id="slide-over-title"><?php echo Module::t('common', 'Slug management'); ?></h2>
        <div class="ml-3 flex h-7 items-center">
            <button type="button" data-overlay-action="close" class="rounded-md bg-indigo-800 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                <span class="sr-only"><?php echo Module::t('common', 'Close panel'); ?></span>
                <?php echo Heroicons::svg('outline/x', ['class' => 'h-6 w-6']); ?>
            </button>
        </div>
    </div>
    <div class="mt-1">
        <p class="text-sm text-indigo-300">
            <?php echo Module::t('common', 'Slug allow an element to be linked in the public space'); ?>
        </p>
    </div>
<?php echo Html::endTag('div'); ?>
<div class="relative flex-1 py-6 px-4 sm:px-6">
    <!-- Replace with your content -->
    <?php echo Html::beginForm(['slug', 'id' => $element->id]); ?>
    <div class="element-form-bloc">
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::activeCheckbox($slug, 'active', []); ?>
        </div>
        <div class="element-form-bloc-grid-12">
            <div class="element-form-bloc-cols-3">
                <?php echo BlackcubeHtml::activeDropDownList($slug, 'host', ArrayHelper::map(Parameter::getAllowedHosts(), 'id', 'value'), []); ?>
            </div>
            <div class="element-form-bloc-cols-9">
                <?php echo BlackcubeHtml::activeTextInput($slug, 'path', []); ?>
            </div>
            <!-- div class="element-form-bloc-cols-1 flex items-end pb-2">
                <?php echo Html::a(Heroicons::svg('solid/refresh', ['class' => 'h-4 w-4']), '', [
                    'class' => 'relative inline-flex items-center p-2.5 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:text-white hover:bg-indigo-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500',
                    'blackcube-url-generator' => Url::toRoute(['ajax/generate-slug', 'id' => $element->id, 'type' => $element::getElementType()])
                ]); ?>
            </div -->
        </div>
    </div>
    <div class="element-form-buttons">
        <?php echo Html::beginTag('button', [
            'type' => 'button',
            'class' => 'element-form-buttons-button',
            'data-overlay-action' => 'close',
        ]); ?>
        <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
        <?php echo Module::t('common', 'Cancel'); ?>
        <?php echo Html::endTag('button'); ?>

        <?php if($slug->isNewRecord === false): ?>
        <?php echo Html::beginTag('button', [
            'type' => 'button',
            'class' => 'element-form-buttons-button delete',
            'data-overlay-action' => 'submit',
            'name' => 'slugDelete',
            'value' => $slug->id,
        ]); ?>
        <?php echo Heroicons::svg('solid/trash', ['class' => 'element-form-buttons-button-icon']); ?>
        <?php echo Module::t('common', 'Delete'); ?>
        <?php echo Html::endTag('button'); ?>
        <?php endif; ?>

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
