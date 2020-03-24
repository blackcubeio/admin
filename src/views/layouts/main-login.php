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
        <!--Import Google Icon Font-->
        <!-- link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" -->
        <!-- Compiled and minified CSS -->
        <!-- link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" -->
        <!-- Compiled and minified JavaScript -->
        <!-- script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script -->
        <!--Let browser know website is optimized for mobile-->
        <!-- link href="//unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet" -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <?php echo Html::tag('meta', '', ['name' => 'X-Version', 'content' => Yii::$app->version]); ?>
        <title>
            <?php echo empty($this->title) ? 'Blackcube' : $this->title; ?>
        </title>
        <?php $this->head(); ?>
    </head>
    <body class="h-screen font-sans login bg-cover">
        <?php $this->beginBody(); ?>
            <?php echo $content; ?>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
