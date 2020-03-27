<?php
/**
 * @var $name string
 * @var $type string
 */

if ($name === null) {
    $name = 'sélectionné';
} else {
    $name = '"'.$name.'"';
}
switch($type)
{
    case 'tag':
        $type = 'le tag';
        break;
    default:
        $type = 'l\'élément';
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
                    Attention, vous allez supprimer <br/>
                    <strong><?php echo $type; ?> <?php echo $name; ?></strong>.<br/>
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
