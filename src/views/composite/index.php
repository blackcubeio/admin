<?php
/**
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 */
use blackcube\admin\helpers\Html;

$formatter = Yii::$app->formatter;
?>
<div class="flex flex-1">
    <?php echo \blackcube\admin\widgets\Sidebar::widget(); ?>
    <main class="overflow-hidden">
        <div class="table-container">
            <div blackcube-ajax-link="" blackcube-attach-modal="">
                <?php echo $this->render('_list', ['compositesQuery' => $compositesQuery]); ?>
            </div>
            <div class="px-6 py-6 flex flex-col xs:flex-row items-center justify-end xs:justify-between">
                <?php echo Html::a(Yii::t('blackcube.admin', 'Create'), ['create'], ['class' => 'text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded']); ?>
            </div>
        </div>
    </main>
</div>
