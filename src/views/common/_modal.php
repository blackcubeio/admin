<?php
/**
 * _modal.php
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
 * @var $element \blackcube\core\models\Tag
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\models\Administrator;
use blackcube\admin\helpers\Html;
use blackcube\core\models\Slug;

if ($element instanceof Administrator) {
    $elementName = $element->email;
} elseif ($element instanceof Slug) {
    $elementName = $element->path;
} elseif (isset($element->name) === true) {
    $elementName = $element->name;
} elseif (isset($element->id) === true) {
    $elementName = $element->id;
} else {
    $elementName = Module::t('common', 'Unknown');
}
?>
<h3 class="text-lg leading-6 font-medium text-gray-900">
    <?php echo Module::t('common', 'Beware, you are going to delete the element:'); ?>
</h3>
<div class="mt-2">
    <strong class="uppercase text-lg text-gray-700"><?php echo $elementName; ?></strong>
    <p class="text-sm text-gray-500">
        <?php echo Module::t('common', 'Do you really want to continue ?'); ?>
    </p>
</div>
