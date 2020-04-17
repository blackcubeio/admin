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
 * @package blackcube\admin\views\user
 *
 * @var $usersQuery \blackcube\core\models\FilterActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use yii\helpers\Url;


$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="table-container">
            <div blackcube-ajax-link="" blackcube-attach-modal="">
                <?php echo $this->render('_list', ['usersQuery' => $usersQuery]); ?>
            </div>
            <div class="buttons">
                <?php if (Yii::$app->user->can(Rbac::PERMISSION_USER_CREATE)): ?>
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('user', 'Create'), ['create'], ['class' => 'button-submit']); ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>
