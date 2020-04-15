<?php
/**
 * _blocs.php
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
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 * @var $element \blackcube\core\models\Tag|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Node
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
use Yii;
$blocsCount = count($blocs);
$pathAlias = Module::getInstance()->adminTemplatesAlias;
?>

<?php foreach($blocs as $i => $bloc): ?>
    <?php if (($adminTemplate = $bloc->getAdminView($pathAlias)) !== false): ?>
        <?php echo Html::activeHiddenInput($bloc, '['.$i.']id'); ?>
        <?php echo $this->render($adminTemplate, ['i' => $i, 'bloc' => $bloc, 'element' => $element]); ?>
    <?php else: ?>
        <?php echo Html::beginTag('div', ['class' => 'bloc'.($bloc->active ? '': ' inactive')]); ?>
        <div class="bloc-subtitle">
            <label class="title"><?php echo $bloc->blocType->name; ?></label>
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
                    <?php echo Html::activeElasticDescription($bloc,  '['.$i.']'.$id, ['class' => 'italic text-xs text-gray-700']); ?>
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
                'class' => 'button delete'
            ]); ?>
                <i class="fa fa-trash-alt"></i>
            <?php echo Html::endTag('button'); ?>
            <?php if ($i === 0): ?>
                <?php echo Html::beginTag('span', [
                    'class' => 'button up inactive'
                ]); ?>
                <i class="fa fa-angle-up"></i>
                <?php echo Html::endTag('span'); ?>
            <?php else: ?>
                <?php echo Html::beginTag('button', [
                    'type' => 'button',
                    'name' => 'blocUp',
                    'value' => $bloc->id,
                    'class' => 'button up'
                ]); ?>
                <i class="fa fa-angle-up"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>
            <?php if ($i >= ($blocsCount - 1)): ?>
                <?php echo Html::beginTag('span', [
                    'class' => 'button down inactive'
                ]); ?>
                <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('span'); ?>
            <?php else: ?>
                <?php echo Html::beginTag('button', [
                    'type' => 'button',
                    'name' => 'blocDown',
                    'value' => $bloc->id,
                    'class' => 'button down'
                ]); ?>
                    <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>

    </div>
<?php endforeach; ?>
