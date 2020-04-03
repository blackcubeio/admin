<?php
/**
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 * @var $element \blackcube\core\models\Category
 */
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
$blocsCount = count($blocs);
$pathAlias = \blackcube\admin\Module::getInstance()->adminTemplatesAlias;
?>

<?php foreach($blocs as $i => $bloc): ?>
    <?php if (($adminTemplate = $bloc->getAdminView($pathAlias)) !== false): ?>
        <?php echo Html::activeHiddenInput($bloc, '['.$i.']id'); ?>
        <?php echo $this->render($adminTemplate, ['i' => $i, 'bloc' => $bloc, 'element' => $element]); ?>
    <?php else: ?>
        <?php echo Html::beginTag('div', ['class' => 'bloc'.($bloc->active ? '': ' inactive')]); ?>
        <div class="bloc-title">
            <label class="title italic"><?php echo $bloc->blocType->name; ?></label>
        </div>
            <?php echo Html::activeHiddenInput($bloc, '['.$i.']id'); ?>
            <?php foreach($bloc->elasticAttributes as $id => $attribute): ?>
                <div class="w-full bloc-fieldset">
                    <?php echo Html::activeLabel($bloc, '['.$i.']'.$id, ['class' => 'label']); ?>
                    <?php // echo Html::activeTextInput($bloc, '['.$i.']'.$id, ['class' => 'textfield'.($bloc->hasErrors($id)?' error':'')]); ?>
                    <?php echo Html::activeElasticField($bloc, '['.$i.']'.$id, [
                        'upload-url' => Url::to(['upload']),
                        'preview-url' => Url::to(['preview', 'name' => '__name__']),
                        'delete-url' => Url::to(['delete', 'name' => '__name__'])
                    ]); ?>
                </div>
            <?php endforeach; ?>
            <!-- AJAX TARGET TO SET THE BLOCS -->
        <?php echo Html::endTag('div'); ?>
    <?php endif; ?>
    <div class="bloc justify-end mx-3 pb-2 border-b border-gray-200">
            <?php echo Html::beginTag('button', [
                'type' => 'button',
                'name' => 'blocDelete',
                'value' => $bloc->id,
                'class' => 'bg-gray-300 hover:bg-red-600 hover:text-white text-xs text-gray-800 font-bold p-1 mr-4 rounded inline-flex items-center  focus:outline-none'
            ]); ?>
                <i class="fa fa-trash-alt"></i>
            <?php echo Html::endTag('button'); ?>
            <?php if ($i === 0): ?>
                <?php echo Html::beginTag('span', [
                    'class' => 'p-1 font-light tracking-wider rounded-l ml-2 text-xs text-gray-700 bg-gray-200 focus:outline-none opacity-25'
                ]); ?>
                <i class="fa fa-angle-up"></i>
                <?php echo Html::endTag('span'); ?>
            <?php else: ?>
                <?php echo Html::beginTag('button', [
                    'type' => 'button',
                    'name' => 'blocUp',
                    'value' => $bloc->id,
                    'class' => 'p-1 font-light hover:text-white hover:bg-blue-800 text-xs tracking-wider rounded-l ml-2 text-gray-700 bg-gray-200 focus:outline-none'
                ]); ?>
                <i class="fa fa-angle-up"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>
            <?php if ($i >= ($blocsCount - 1)): ?>
                <?php echo Html::beginTag('span', [
                    'class' => 'p-1 font-light tracking-wider rounded-r mr-0 text-xs text-gray-700 bg-gray-200 focus:outline-none opacity-25'
                ]); ?>
                <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('span'); ?>
            <?php else: ?>
                <?php echo Html::beginTag('button', [
                    'type' => 'button',
                    'name' => 'blocDown',
                    'value' => $bloc->id,
                    'class' => 'p-1 font-light hover:text-white hover:bg-blue-800 text-xs tracking-wider rounded-r mr-0 text-gray-700 bg-gray-200 focus:outline-none'
                ]); ?>
                    <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>

    </div>
<?php endforeach; ?>
