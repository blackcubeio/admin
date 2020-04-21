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
} else {
    $elementName = $element->name;
}
?>
<div class="modal" id="modal-delete">
    <div class="inner">
        <div class="info">
            <div class="header danger">
                <h3><?php echo Module::t('common', 'Delete'); ?></h3>
                <button id="modal-delete-cross"><span>×</span></button>
            </div>
            <div class="body">
                <p>
                    <?php echo Module::t('common', 'Beware, you are going to delete the element:'); ?>
                </p>
                    <strong class="uppercase text-sm"><?php echo $elementName; ?></strong>
                <p>
                    <?php echo Module::t('common', 'Do you really want to conitnue ?'); ?>
                </p>
            </div>
            <div class="footer">
                <button class="close" type="button" style="transition: all .15s ease" id="modal-delete-close"><?php echo Module::t('common', 'Cancel'); ?></button>
                <button class="run" type="button" style="transition: all .15s ease" id="modal-delete-ok"><?php echo Module::t('common', 'Delete'); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop" id="modal-delete-backdrop"></div>
