<?php
/**
 * form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\parameter
 *
 * @var $parameter \blackcube\core\models\Parameter
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\core\Module as CoreModule;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$allowedParameterDomains = CoreModule::getInstance()->allowedParameterDomains;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
            <ul class="header">
                <li>
                    <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('parameter', 'Back'), ['index'], ['class' => 'button']); ?>
                </li>
                <li>
                    <?php echo Html::a('<i class="fa fa-check mr-2"></i> '.Module::t('parameter', 'Save'), ['index'], ['class' => 'button']); ?>
                </li>
            </ul>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('parameter', 'Parameter'); ?></span>
                </div>
            </div>

            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/2">
                    <?php echo Html::activeLabel($parameter, 'domain', ['class' => 'label']); ?>
                    <?php if (empty($allowedParameterDomains) === true): ?>
                        <?php echo Html::activeTextInput($parameter, 'domain', ['class' => 'textfield'.($parameter->hasErrors('domain')?' error':'')]); ?>
                    <?php else: ?>
                        <div class="dropdown">
                            <?php echo Html::activeDropDownList($parameter, 'domain', ArrayHelper::map($allowedParameterDomains, function($item) { return $item; }, function($item) { return $item; }), [
                            ]); ?>
                            <div class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
                <div class="w-full bloc-fieldset md:w-1/2">
                    <?php echo Html::activeLabel($parameter, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($parameter, 'name', ['class' => 'textfield'.($parameter->hasErrors('name')?' error':'')]); ?>
                </div>
            </div>

        <div class="bloc">
            <div class="w-full bloc-fieldset">
                <?php echo Html::activeLabel($parameter, 'value', ['class' => 'label']); ?>
                <?php echo Html::activeTextarea($parameter, 'value', ['class' => 'textfield'.($parameter->hasErrors('value')?' error':'')]); ?>
            </div>
        </div>


            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('parameter', 'Cancel'), ['index'], [
                    'class' => 'button-cancel'
                ]); ?>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('parameter', 'Save'), [
                    'type' => 'submit',
                    'class' => 'button-submit'
                ]); ?>
            </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
