<?php
/**
 * _sitemap.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\common
 *
 * @var $element \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag
 * @var $sitemap \blackcube\core\models\Sitemap
 * @var $saved bool|null
 * @var $frequencies array
 * @var $priorities array
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
        'content.bind' => Module::t('common', 'Sitemap was saved'),
    ]);
    $additionalOptions['blackcube-broadcast-element'] = Aurelia::bindOptions([
        'events.bind' => ['update', ($sitemap->active?'activate': 'deactivate')],
        'type.bind' => 'sitemap',
        'id.bind' => $sitemap->id,
    ]);
    $additionalOptions['blackcube-overlay-close'] = '';
} elseif ($saved === false) {
    $additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
        'title.bind' => Module::t('common', 'Error'),
        'type.bind' => 'exclamation',
        'content.bind' => Module::t('common', 'Sitemap was not saved'),
    ]);
}
?>

<?php echo Html::beginTag('div', [
    'class' => 'bg-indigo-800 py-6 px-4 sm:px-6'
] + $additionalOptions); ?>
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-medium text-white" id="slide-over-title"><?php echo Module::t('common', 'Sitemap management'); ?></h2>
        <div class="ml-3 flex h-7 items-center">
            <button type="button" data-overlay-action="close" class="rounded-md bg-indigo-800 text-indigo-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                <span class="sr-only"><?php echo Module::t('common', 'Close panel'); ?></span>
                <?php echo Heroicons::svg('outline/x', ['class' => 'h-6 w-6']); ?>
            </button>
        </div>
    </div>
    <div class="mt-1">
        <p class="text-sm text-indigo-300">
            <?php echo Module::t('common', 'Sitemap is Slug dependant. It will be activated for the website only if Slug is active'); ?>
        </p>
    </div>
<?php echo Html::endTag('div'); ?>
<div class="relative flex-1 py-6 px-4 sm:px-6">
    <!-- Replace with your content -->
    <?php echo Html::beginForm(['sitemap', 'id' => $element->id]); ?>
    <div class="element-form-bloc">
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::activeCheckbox($sitemap, 'active', []); ?>
        </div>
        <div class="element-form-bloc-grid-12">
            <div class="element-form-bloc-cols-6">
                <?php echo BlackcubeHtml::activeDropDownList($sitemap, 'frequency', $frequencies, []); ?>
            </div>
            <div class="element-form-bloc-cols-6">
                <?php echo BlackcubeHtml::activeDropDownList($sitemap, 'priority', $priorities, []); ?>
            </div>
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
