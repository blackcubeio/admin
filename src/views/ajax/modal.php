<?php
/**
 * @var $name string
 * @var $type string
 */

switch($type)
{
    case \blackcube\core\models\Tag::getElementType():
        $type = 'le tag';
        break;
    default:
        $type = 'l\'élément sélectionné';
        break;
}
?>
<div class="modal" id="modal-delete">
    <div class="inner">
        <div class="info">
            <div class="header">
                <h3>Suppression</h3>
                <button id="modal-delete-cross"><span>×</span></button>
            </div>
            <div class="body">
                <p>
                    Attention, vous allez supprimer <?php echo $type; ?>
                </p>
                <?php if ($name !== null): ?>
                    <strong class="uppercase text-sm"><?php echo $name; ?></strong>
                <?php endif; ?>
                <p>
                    Etes vous certain de vouloir continuer ?
                </p>
            </div>
            <div class="footer">
                <button class="close" type="button" style="transition: all .15s ease" id="modal-delete-close">Non</button>
                <button class="run" type="button" style="transition: all .15s ease" id="modal-delete-ok">Supprimer</button>
            </div>
        </div>
    </div>
</div>
<div class="modal-backdrop" id="modal-delete-backdrop"></div>
