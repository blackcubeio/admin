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
 * @package blackcube\admin\views\tag
 *
 * @var $tagsQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
$currentCategoryId = null;
?>
    <table class="w-48">
        <thead>
            <tr>
                <th>
                    <?php echo Module::t('tag', 'Name'); ?>
                    <!-- input type="text" class="appearance-none bg-gray-200 text-gray-700 border border-gray-300 rounded py-1 px-4 mb-1 leading-tight"
                    placeholder="<?php echo Module::t('tag', 'Name'); ?>" -->
                </th>
                <th class="type">
                    <?php echo Module::t('tag', 'Type'); ?>
                </th>
                <th class="status">
                    <?php echo Module::t('tag', 'Status'); ?>
                </th>
                <th class="tools">
                    <?php echo Module::t('tag', 'Action'); ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tagsQuery->each() as $tag): ?>
            <?php /* @var \blackcube\core\models\Tag $tag */ ?>
            <?php if ($currentCategoryId !== $tag->categoryId): ?>
                <?php $currentCategoryId = $tag->categoryId; ?>
                <tr>
                    <td colspan="4" class="category">
                        <?php echo $tag->category->name; ?>
                        <span class="text-xs italic">(<?php echo $tag->category->language->id; ?>)</span>
                        <?php /*/ if($tag->category->active): ?><span class="text-xxs text-white bg-green-600 rounded-full p-1 ml-4"><i class="fa fa-eye"></i></span><?php else: ?><span class="text-xxs text-white bg-red-600 rounded-full p-1 ml-4"><i class="fa fa-eye-slash"></i></span><?php endif; /**/ ?>
                    </td>
                </tr>
            <?php endif; ?>
                <?php echo Html::beginTag('tr', ['data-ajaxify-target' => 'tag-toggle-active-'.$tag->id]); ?>
                    <?php echo $this->render('_line', ['tag' => $tag]); ?>
                <?php echo Html::endTag('tr'); ?>
            <?php endforeach; ?>
        </tbody>
    </table>
