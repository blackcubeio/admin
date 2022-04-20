<?php
/**
 * _line.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\language
 *
 * @var $element
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;

use blackcube\admin\helpers\Heroicons;
use blackcube\admin\widgets\SimpleElementCard;
use blackcube\admin\widgets\ElementListHeader;
use blackcube\admin\widgets\ElementListPagination;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;


?>
        <?php /* @var \blackcube\core\models\Language $element */ ?>
        <?php echo SimpleElementCard::widget([
            'element' => $element,
        'elementType' => 'language'
        ]); ?>
