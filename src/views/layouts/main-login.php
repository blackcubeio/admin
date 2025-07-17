<?php
/**
 * main.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $content string
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use blackcube\admin\assets\WebpackAsset;
use blackcube\admin\assets\FaviconAsset;

FaviconAsset::register($this);
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
    <body class="login">
        <?php $this->beginBody(); ?>
            <?php echo $content; ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
