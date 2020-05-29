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
 * @package blackcube\admin\views\category
 *
 * @var $categoriesProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
?>
    <table>
        <thead>
            <tr>
                <th>
                    <?php echo Html::a(Module::t('category', 'Name'),
                        $categoriesProvider->sort->createUrl('name'),
                        []
                    ); ?>
                </th>
                <th class="type">
                    <?php echo Html::a(Module::t('category', 'Type'),
                        $categoriesProvider->sort->createUrl('type'),
                        []
                    ); ?>
                </th>
                <th class="status">
                    <?php echo Html::a(Module::t('category', 'Status'),
                        $categoriesProvider->sort->createUrl('active'),
                        []
                    ); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('category', 'Action'); ?>
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
            <?php foreach ($categoriesProvider->getModels() as $category): ?>
            <?php /* @var \blackcube\core\models\Category $category */ ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'category-toggle-active-'.$category->id]); ?>
                <?php echo $this->render('_line', ['category' => $category]); ?>
                <?php echo Html::endTag('tr'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
