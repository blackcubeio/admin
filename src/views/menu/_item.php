<?php
/**
 * _item.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\menu
 *
 * @var $menuItem \blackcube\core\models\MenuItem
 * @var $level integer
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\core\components\Element;
use blackcube\core\models\Composite;
use blackcube\core\models\Node;
use blackcube\core\models\Tag;
use blackcube\core\models\Category;
use blackcube\core\models\MenuItem;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use yii\helpers\Url;
use blackcube\admin\widgets\MenuItemCard;

?>
<?php echo MenuItemCard::widget([
    'level' => $level,
    'menuItem' => $menuItem
]); ?>
<?php foreach($menuItem->getChildren()->each() as $idx => $subMenuItem): ?>
    <?php /* @var $menuItem \blackcube\core\models\MenuItem */?>
    <?php echo $this->render('_item', [
        'level' => ($level + 1),
        'menuItem' => $subMenuItem
    ]); ?>
<?php endforeach; ?>

