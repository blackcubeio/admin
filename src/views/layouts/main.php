<?php
/**
 * main.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2019 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package webapp\views\layouts
 *
 * @var $this yii\web\View
 * @var $content string
 */

use yii\helpers\Html;
use blackcube\admin\assets\WebpackAsset;

WebpackAsset::register($this);

$this->beginPage(); ?><!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php echo Html::tag('meta', '', ['name' => 'X-Version', 'content' => Yii::$app->version]); ?>
        <title>
            <?php echo empty($this->title) ? 'Blackcube' : $this->title; ?>
        </title>
        <?php $this->head(); ?>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <!-- div class="loader" blackcube-loader="">
            <span>
                <i class="fas fa-circle-notch fa-spin fa-5x"></i>
            </span>
        </div -->
        <!--Container -->
        <div class="mx-auto">
            <!--Screen-->
            <div class="min-h-screen flex flex-col">
                <?php echo \blackcube\admin\widgets\Header::widget(); ?>

                <?php echo $content; ?>

                <?php echo \blackcube\admin\widgets\Footer::widget(); ?>
            </div>
            <!--Screen-->
        </div>
        <!--Container -->
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
