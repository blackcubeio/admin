<?php
/**
 * _slug_delete.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\common
 *
 * @var $slugId int
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\models\Administrator;
use blackcube\admin\helpers\Html;
use blackcube\core\models\Slug;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Heroicons;
use yii\helpers\ArrayHelper;
use blackcube\core\models\Parameter;
use blackcube\admin\helpers\Aurelia;
use yii\helpers\Url;

$additionalOptions = [];
$additionalOptions['blackcube-notification-trigger'] = Aurelia::bindOptions([
    'title.bind' => 'Success',
    'type.bind' => 'check',
    'content.bind' => Module::t('common', 'Slug was deleted'),
]);
$additionalOptions['blackcube-broadcast-element'] = Aurelia::bindOptions([
    'event.bind' => 'delete',
    'type.bind' => Slug::getElementType(),
    'id.bind' => $slugId,
]);
$additionalOptions['blackcube-overlay-close'] = '';
?>

<?php echo Html::beginTag('div', [
    'class' => 'bg-indigo-800 py-6 px-4 sm:px-6'
] + $additionalOptions); ?>

<?php echo Html::endTag('div'); ?>