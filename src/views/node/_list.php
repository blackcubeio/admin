<?php
/**
 * _list.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\node
 *
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('node', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('node', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('node', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('node', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('node', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($nodesQuery->each() as $node): ?>
            <?php /* @var \blackcube\core\models\Node $node */ ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'node-toggle-active-'.$node->id]); ?>
                <?php echo $this->render('_line', ['node' => $node]); ?>
                <?php echo Html::endTag('tr'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
