<?php
/**
 * _composites.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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




