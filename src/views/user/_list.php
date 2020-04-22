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
 * @package blackcube\admin\views\user
 *
 * @var $usersQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;


$formatter = Yii::$app->formatter;
?>
    <table>
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('bloc-type', 'Name'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('bloc-type', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usersQuery->each() as $user): ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'user-toggle-active-'.$user->id]); ?>
                <?php echo $this->render('_line', ['user' => $user]); ?>
                <?php echo Html::endTag('tr'); ?>

            <?php endforeach; ?>
        </tbody>
    </table>
