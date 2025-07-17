<?php
/**
 * _nodes.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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




