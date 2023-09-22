<?php
/**
 * _blocs.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\common
 *
 * @var $blocs \blackcube\core\models\Bloc[]
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


$blocsCount = count($blocs);
$pathAlias = Module::getInstance()->adminTemplatesAlias;
Bo::registerExternalAssets($element, $this);
?>

<?php foreach($blocs as $i => $bloc): ?>
<div class="mt-4">
    <div class="element-form-bloc-wrapper">
        <div class="element-form-bloc">
            <h3 class="element-form-bloc-title">
                <?php echo $bloc->blocType->name; ?>
            </h3>
            <?php echo Html::beginTag('div', ['class' => 'element-form-bloc-inner' . ($bloc->active ? '' : ' inactive')]); ?>
                <?php echo Html::activeHiddenInput($bloc, '['.$i.']id'); ?>
                <?php if (($adminTemplate = $bloc->getAdminView($pathAlias)) !== false): ?>

                    <?php echo $this->render($adminTemplate, ['i' => $i, 'bloc' => $bloc, 'element' => $element]); ?>
                <?php else: ?>
                    <?php foreach($bloc->elasticAttributes as $id => $attribute): ?>
                    <?php
                        $structure = $bloc->structure[$id];
                        $field = $structure['field'];
                        switch ($field):
                            case 'file':
                            case 'files':
                                echo BlackcubeHtml::activeElasticField($bloc, '[' . $i . ']' . $id, [
                                    'upload-url' => Url::to(['file-upload']),
                                    'preview-url' => Url::to(['file-preview', 'name' => '__name__']),
                                    'delete-url' => Url::to(['file-delete', 'name' => '__name__'])
                                ]);
                                break;
                            default:
                                echo BlackcubeHtml::activeElasticField($bloc, '['.$i.']'.$id);
                                break;
                        endswitch;;
                    ?>

                <?php endforeach; ?>
                <?php endif; ?>
                <div class="element-form-bloc-toolbar">
                    <span class="element-form-bloc-toolbar-buttons">
                        <?php echo Html::beginTag('button', [
                            'type' => 'button',
                            'name' => 'blocDelete',
                            'value' => $bloc->id,
                            'class' => 'element-form-bloc-toolbar-buttons-button delete'
                        ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Delete'); ?></span>
                            <?php echo Heroicons::svg('outline/trash', ['class' => 'h-4 w-4']); ?>
                        <?php echo Html::endTag('button'); ?>
                    </span>
                    <span class="element-form-bloc-toolbar-buttons">
                        <?php if ($i > 0): ?>
                        <?php echo Html::beginTag('button', [
                            'type' => 'button',
                            'name' => 'blocUp',
                            'value' => $bloc->id,
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
                        <?php if ($i >= ($blocsCount - 1)): ?>
                            <?php echo Html::beginTag('span', [
                                'class' => 'element-form-bloc-toolbar-buttons-button disabled'
                            ]); ?>
                            <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                            <?php echo Html::endTag('span'); ?>
                        <?php else: ?>
                        <?php echo Html::beginTag('button', [
                            'type' => 'button',
                            'name' => 'blocDown',
                            'value' => $bloc->id,
                            'class' => 'element-form-bloc-toolbar-buttons-button'
                        ]); ?>
                            <span class="sr-only"><?php Module::t('common', 'Down'); ?></span>
                            <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-4 w-4']); ?>
                        <?php echo Html::endTag('button'); ?>
                        <?php endif; ?>
                    </span>
                    <span class="element-form-bloc-toolbar-buttons">
                        <?php if ($element->type && $element->type->getBlocTypes()->count() > 0): ?>
                            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                                <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($element->type->blocTypes, 'id', 'name'), [
                                    'class' => 'block w-full pl-3 pr-9 py-2 rounded-r-none rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-indigo-500'
                                ]); ?>
                                <button name="blocAdd" value="<?php echo $bloc->id; ?>" type="button" class="-ml-px relative inline-flex items-center rounded-r-md border border-gray-300 bg-white p-2 text-gray-700 focus:outline-none focus:ring-1 focus:ring-offset-0 focus:ring-indigo-500 hover:text-white hover:bg-indigo-800">
                                    <?php echo Heroicons::svg('solid/plus', ['class' => 'h-4 w-4']); ?>
                                </button>
                            </span>
                        <?php endif; ?>
                    </span>
                </div>
            <?php echo Html::endTag('div'); ?>
        </div>
    </div>

</div>
<?php endforeach; ?>
<?php if ($element->type && $element->type->getBlocTypes()->count() > 0 && $blocsCount == 0): ?>
    <div class="p-6">
        <div class="text-right">
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($element->type->blocTypes, 'id', 'name'), [
                    'class' => 'block w-full pl-3 pr-9 py-2 rounded-r-none rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500'
                ]); ?>

                <button name="blocAdd" type="button" class="-ml-px relative inline-flex items-center rounded-r-md border border-gray-300 bg-white p-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 hover:text-white hover:bg-indigo-800">
                    <?php echo Heroicons::svg('solid/plus', ['class' => 'h-4 w-4']); ?>
                </button>
            </span>
        </div>
    </div>
<?php endif; ?>