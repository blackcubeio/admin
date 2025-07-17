<?php
/**
 * _blocs.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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




