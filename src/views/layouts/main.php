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
 * @var $content string
 * @var $this \yii\web\View
 */

use blackcube\admin\helpers\Html;
use blackcube\admin\assets\WebpackAsset;
use blackcube\admin\assets\FaviconAsset;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\Header;
use blackcube\admin\helpers\Aurelia;
use blackcube\admin\Module;

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
    <body>
        <?php $this->beginBody(); ?>
        <?php echo Html::beginTag('div', [
                'class' => 'h-screen flex overflow-hidden bg-gray-100',
            'blackcube-ajaxify' => '',
            'blackcube-alert-delete' => Aurelia::bindOptions([
                'cancel.bind' => Module::t('common', 'Cancel'),
                'action.bind' => Module::t('common', 'Delete'),
            ])
        ]); ?>
            <?php echo Sidebar::widget(); ?>

            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <?php echo Header::widget(); ?>
                <div class="flex-1 relative overflow-y-auto focus:outline-none">

                        <?php echo $content; ?>

                </div>
            </div>

            <?php echo Aurelia::component('blackcube-alert', '', []); ?>

            <?php
            /**/
            echo Aurelia::component('blackcube-overlay', '', [
                'class' => 'overlay',
                'aria-labelledby' => 'slide-over-title',
                'role' => 'dialog',
                'aria-modal' => 'true'
            ]);
            /**/
            ?>

            <?php echo Aurelia::component('blackcube-notification-center', '', []); ?>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage();
