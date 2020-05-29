<?php
/**
 * index.php
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
 * @var $tagsProvider \yii\data\ActiveDataProvider
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\widgets\LinkPager;

?>
    <main class="overflow-hidden">
        <div class="table-container">
            <div blackcube-ajaxify="click" blackcube-attach-modal="" >
                <?php echo $this->render('_list', ['tagsProvider' => $tagsProvider]); ?>
            </div>
            <div class="text-center">
                <?php echo LinkPager::widget([
                    'pagination' => $tagsProvider->pagination,
                    'prevPageLabel' => '<i class="fa fa-angle-left"></i>',
                    'firstPageLabel' => '<i class="fa fa-angle-double-left"></i>',
                    'nextPageLabel' => '<i class="fa fa-angle-right"></i>',
                    'lastPageLabel' => '<i class="fa fa-angle-double-right"></i>',
                ]); ?>
            </div>
            <div class="buttons">
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_TAG_CREATE)): ?>
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('tag', 'Create'), ['create'], ['class' => 'button-submit']); ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

