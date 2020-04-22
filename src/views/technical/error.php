<?php
/**
 * error.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\technical
 *
 * @var $this \yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception Exception
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use yii\web\Response;

if ($exception instanceof \yii\web\HttpException) {
    $code = $exception->statusCode;
    $definition = isset(Response::$httpStatuses[$code]) ? Response::$httpStatuses[$code] : 'An internal server error occurred.';
} else {
    $code = 'XXX';
    $definition = 'An internal server error occurred.';
}

?>
<div class="container mx-auto h-full flex flex-1 justify-center items-center">
    <div class="w-full max-w-lg">
        <div class="leading-loose">
            <div class="max-w-xl m-4 p-10 bg-white rounded shadow-xl">
                <p class="text-gray-800 font-medium text-center text-xl font-bold">
                <?php echo Module::t('technical', '{code} - {definition}', [
                    'code' => $code,
                    'definition' => $definition
                ]); ?></p>
                <?php echo Html::a(Module::t('error', 'Take Me Back To Home'), ['dashboard/index'], [
                    'class' => 'px-4 py-1 text-white font-light tracking-wider bg-gray-900 rounded ml-24'
                ]); ?>
            </div>

        </div>
    </div>
</div>
