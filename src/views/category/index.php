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
 * @package blackcube\admin\views\category
 *
 * @var $this yii\web\View
 * @var $categoriesQuery \blackcube\core\models\FilterActiveQuery
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
                <?php echo $this->render('_list', ['categoriesQuery' => $categoriesQuery]); ?>
            </div>
            <div class="px-6 py-6 flex flex-col xs:flex-row items-center justify-end xs:justify-between">
                <?php echo Html::a(Module::t('category', 'Create'), ['create'], ['class' => 'text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded']); ?>
            </div>
        </div>
    </main>
</div>
