<?php
/**
 * main.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\layouts
 *
 * @var $content string
 * @var $this \yii\web\View
 */

use blackcube\admin\assets\WebpackAsset;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\Header;
use blackcube\admin\widgets\Footer;

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
                <?php echo Header::widget(); ?>
                <div class="flex flex-1">
                    <?php echo Sidebar::widget(); ?>

                <?php echo $content; ?>
                </div>

                <?php echo Footer::widget(); ?>
            </div>
            <!--Screen-->
        </div>
        <!--Container -->
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
