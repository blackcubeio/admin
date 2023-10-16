<?php
/**
 * _composites.php
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
 * @var $composites array
 * @var $compositesQuery \yii\db\ActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\BlackcubeHtml;
use yii\helpers\ArrayHelper;

?>

<?php if (isset($composites) === true && is_array($composites)): ?>
    <?php foreach ($composites as $compositeId): ?>
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::dropDownList('nodeId[]',  $compositeId, ArrayHelper::map($compositesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                'label' => Module::t('import', 'Composite'),
                'hint' => Module::t('import', 'Composite which will be tagged'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>




