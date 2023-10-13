<?php
/**
 * _nodes.php
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
 * @var $nodes array
 * @var $nodesQuery \yii\db\ActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\BlackcubeHtml;
use yii\helpers\ArrayHelper;

?>

<?php if (isset($nodes) === true && is_array($nodes)): ?>
    <?php foreach ($nodes as $nodeId): ?>
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::dropDownList('nodeId[]',  $nodeId, ArrayHelper::map($nodesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                'label' => Module::t('import', 'Node'),
                'hint' => Module::t('import', 'Node which will be tagged'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>




