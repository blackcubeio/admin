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
 * @package blackcube\admin\views\node
 *
 * @var $this yii\web\View
 * @var $nodesQuery \blackcube\core\models\FilterActiveQuery
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="table-container">
            <div blackcube-ajax-link="" blackcube-attach-modal="">
                <?php echo $this->render('_list', ['nodesQuery' => $nodesQuery]); ?>
            </div>
            <div class="buttons">
                <?php echo Html::a('<i class="fa fa-plus mr-2"></i> '.Module::t('node', 'Create'), ['create'], ['class' => 'button-submit']); ?>
            </div>
        </div>
    </main>
</div>
