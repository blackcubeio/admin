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
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $compositesProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginAdminHookInterface;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Html::a(Module::t('composite', 'Name'),
                        $compositesProvider->sort->createUrl('name'),
                        []
                    ); ?>
                </th>
                <th class="type">
                    <?php echo Html::a(Module::t('composite', 'Type'),
                        $compositesProvider->sort->createUrl('type'),
                        []
                    ); ?>
                </th>
                <th class="status">
                    <?php echo Html::a(Module::t('composite', 'Status'),
                        $compositesProvider->sort->createUrl('active'),
                        []
                    ); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('composite', 'Action'); ?>
                </th>
            </tr>
            <tr>
                <td colspan="4">
                    <?php echo Html::beginForm(['index'], 'get', [
                        'class' => 'flex border border-gray-600 rounded'
                    ]); ?>
                    <?php echo Html::textInput('search', Yii::$app->request->getQueryParam('search'), [
                        'class' => 'outline-none focus:outline-none flex-1 m-0 p-3'
                    ]); ?>
                    <?php echo Html::a('<i class="fa fa-times"></i>', ['index', 'sort' => Yii::$app->request->getQueryParam('sort')], [
                        'class' => 'outline-none focus:outline-none  flex-none m-0 p-3 bg-gray-200 hover:bg-red-600 hover:text-white'
                    ]); ?>
                    <button type="submit" class="outline-none focus:outline-none  flex-none m-0 p-3 bg-gray-200 hover:bg-blue-800 hover:text-white">
                        <i class="fa fa-search"></i>
                    </button>
                    <?php if (empty(Yii::$app->request->getQueryParam('sort')) === false): ?>
                        <?php echo Html::hiddenInput('sort', Yii::$app->request->getQueryParam('sort')); ?>
                    <?php endif; ?>
                    <?php echo Html::endForm(); ?>
                </td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($compositesProvider->getModels() as $composite): ?>
            <?php /* @var \blackcube\core\models\Composite $composite */ ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'composite-toggle-active-'.$composite->id]); ?>
                <?php echo $this->render('_line', ['composite' => $composite]); ?>
                <?php echo Html::endTag('tr'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
