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
 * @package blackcube\admin\views\composite
 *
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('composite', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('composite', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('composite', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('composite', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('composite', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compositesQuery->each() as $composite): ?>
            <?php /* @var \blackcube\core\models\Composite $composite */ ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'composite-toggle-active-'.$composite->id]); ?>
                <?php echo $this->render('_line', ['composite' => $composite]); ?>
                <?php echo Html::endTag('tr'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
