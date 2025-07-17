<?php
/**
 * _blocs.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $element \blackcube\core\models\Tag|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Node
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\helpers\Bo;
use yii\base\InvalidArgumentException;
use yii\helpers\Url;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;
use yii\helpers\ArrayHelper;
use blackcube\admin\components\Rbac;

?>

<?php $compositesCount = $element->getComposites()->count(); ?>
<?php foreach($element->getComposites()->each() as $i => $composite): ?>
<div class="flex justify-between items-center px-6">
    <div class="text-sm text-gray-700 truncate">
        <?php echo Html::encode($composite->name); ?>
        <span class="text-xs italic">(#<?php echo Html::encode($composite->id); ?>)</span>
    </div>
    <div class="element-form-bloc-toolbar py-2">
                    <span class="element-form-bloc-toolbar-buttons">
                        <?php echo Html::beginTag('button', [
                            'type' => 'button',
                            'name' => 'compositeDetach',
                            'value' => $composite->id,
                            'class' => 'element-form-bloc-toolbar-buttons-button delete'
                        ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Detach'); ?></span>
                            <?php echo Heroicons::svg('outline/ban', ['class' => 'h-4 w-4']); ?>
                        <?php echo Html::endTag('button'); ?>
                        <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_UPDATE)): ?>
                        <?php echo Html::beginTag('a', [
                            'href' => Url::to(['composite/edit', 'id' => $composite->id]),
                            'name' => 'compositeDetach',
                            'class' => 'element-form-bloc-toolbar-buttons-button'
                        ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Edit'); ?></span>
                            <?php echo Heroicons::svg('outline/pencil-alt', ['class' => 'h-4 w-4']); ?>
                        <?php echo Html::endTag('a'); ?>
                        <?php endif; ?>
                    </span>
                    <?php if($element instanceof \blackcube\core\models\Node): ?>
                    <span class="element-form-bloc-toolbar-buttons">
                        <?php if ($i > 0): ?>
                            <?php echo Html::beginTag('button', [
                                'type' => 'button',
                                'name' => 'compositeUp',
                                'value' => $composite->id,
                                'class' => 'element-form-bloc-toolbar-buttons-button'
                            ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Up'); ?></span>
                            <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('button'); ?>
                        <?php else: ?>
                            <?php echo Html::beginTag('span', [
                                'class' => 'element-form-bloc-toolbar-buttons-button disabled'
                            ]); ?>
                            <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('span'); ?>
                        <?php endif; ?>
                        <?php if ($i >= ($compositesCount - 1)): ?>
                    <?php echo Html::beginTag('span', [
                        'class' => 'element-form-bloc-toolbar-buttons-button disabled'
                    ]); ?>
                        <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                    <?php echo Html::endTag('span'); ?>
                <?php else: ?>
                    <?php echo Html::beginTag('button', [
                        'type' => 'button',
                        'name' => 'compositeDown',
                        'value' => $composite->id,
                        'class' => 'element-form-bloc-toolbar-buttons-button'
                    ]); ?>
                        <span class="sr-only"><?php Module::t('common', 'Down'); ?></span>
                    <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>
                    </span>
                    <?php endif; ?>
    </div>
</div>

<?php endforeach; ?>
<?php /*/if ($element->type && $element->type->getBlocTypes()->count() > 0): ?>
    <div class="p-6">
        <div class="text-right">
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($element->type->blocTypes, 'id', 'name'), [
                    'class' => 'block w-full pl-3 pr-9 py-2 rounded-r-none rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
                ]); ?>

                <button name="blocAdd" type="button"class="-ml-px relative inline-flex items-center rounded-r-md border border-gray-300 bg-white p-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:text-white hover:bg-indigo-800">
                    <?php echo Heroicons::svg('solid/plus', ['class' => 'h-4 w-4']); ?>
                </button>
            </span>
        </div>
    </div>
<?php endif;/**/ ?>