<?php
/**
 * _composites.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\node
 *
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 * @var $element \blackcube\core\models\Node
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
// use Yii;
$compositesCount = $compositesQuery->count();
?>

<?php foreach($compositesQuery->each() as $i => $composite): ?>
    <?php /* @var \blackcube\core\models\Composite $composite */ ?>
    <div class="bloc">
        <div class="bloc-subtitle">
            <label class="title"><?php echo $composite->name; ?> <span class="text-xs italic">(<?php echo $composite->language->id; ?>)</span>
                <?php echo Html::a('<i class="pl-4 fa fa-pen-alt opacity-50 hover:opacity-100"></i>', ['composite/edit', 'id' => $composite->id]); ?>
            </label>
        </div>
    </div>
        <?php if (($composite->dateStart !== null) || ($composite->dateEnd !== null)): ?>
        <div class="bloc">
            <div class="text-xs text-gray-600 italic mx-4">
                    <?php if ($composite->dateStart !== null): ?>
                        <?php echo Module::t('composite', 'Start: {0,date,medium}', [$composite->activeDateStart]); ?>

                    <?php endif; ?>
                    <?php if ($composite->dateEnd !== null): ?>
                        <?php echo Module::t('composite', 'End: {0,date,medium}', [$composite->activeDateEnd]); ?>
                    <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if (($composite->slug !== null) && ($composite->slug->seo !== null)): ?>
        <div class="bloc">
            <div class="text-xs text-gray-600 italic mx-4">
                <?php echo $composite->slug->seo->title; ?>
            </div>
        </div>
        <?php endif; ?>
    <div class="bloc justify-end mx-3 pb-2 border-b border-gray-200">
            <?php echo Html::beginTag('button', [
                'type' => 'button',
                'name' => 'compositeDelete',
                'value' => $composite->id,
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
                    'name' => 'compositeUp',
                    'value' => $composite->id,
                    'class' => 'button up'
                ]); ?>
                <i class="fa fa-angle-up"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>
            <?php if ($i >= ($compositesCount - 1)): ?>
                <?php echo Html::beginTag('span', [
                    'class' => 'button down inactive'
                ]); ?>
                <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('span'); ?>
            <?php else: ?>
                <?php echo Html::beginTag('button', [
                    'type' => 'button',
                    'name' => 'compositeDown',
                    'value' => $composite->id,
                    'class' => 'button down'
                ]); ?>
                    <i class="fa fa-angle-down"></i>
                <?php echo Html::endTag('button'); ?>
            <?php endif; ?>

    </div>
<?php endforeach; ?>
