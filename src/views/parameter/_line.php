<?php
/**
 * _line.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $element
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use blackcube\core\models\Node;
use blackcube\core\models\Composite;
use blackcube\core\models\Tag;
use blackcube\core\models\Slug;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\widgets\SimpleElementCard;
use blackcube\admin\widgets\ElementListHeader;
use blackcube\admin\widgets\ElementListPagination;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;


?>
        <?php echo SimpleElementCard::widget([
            'element' => $element,
            'elementType' => 'parameter',
        ]); ?>
