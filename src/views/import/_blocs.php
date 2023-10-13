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
 * @package blackcube\admin\import\composite
 *
 * @var $blocs array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\BlackcubeHtml;

?>

<div class="element-form-bloc-stacked">
    <?php echo BlackcubeHtml::input('number',  'blocs', $blocs ? count($blocs) : 0 , [
        'hint' => Module::t('import', 'Number of blocs which will be imported'),
        'label' => Module::t('import', 'Blocs'),
        'disabled' => 'disabled'
    ]); ?>
</div>




