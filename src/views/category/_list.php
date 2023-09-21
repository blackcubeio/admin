<?php
/**
 * _list.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\category
 *
 * @var $elementsProvider \yii\data\ActiveDataProvider
 * @var $icon string
 * @var $title string
 * @var $additionalLinkOptions array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Publication;
use blackcube\core\models\Node;
use blackcube\core\models\Composite;
use blackcube\core\models\Category;
use blackcube\core\models\Tag;
use blackcube\core\models\Slug;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\widgets\ElementCard;
use blackcube\admin\widgets\ElementListHeader;
use blackcube\admin\widgets\ElementListPagination;
use yii\helpers\Url;

$formatter = Yii::$app->formatter;


?>
<div role="list" class="elements-list">
    <?php echo ElementListHeader::widget([
        'icon' => $icon,
        'title' => $title,
    ]); ?>
    <?php foreach ($elementsProvider->getModels() as $element): ?>
    <?php echo Html::beginTag('div', ['data-ajaxify-target' => $element::getElementType().'-toggle-active-'.$element->id]); ?>
        <?php echo $this->render('_line', [
                'element' => $element
        ]); ?>
        <?php /* @var \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag|\blackcube\core\models\Slug $element */ ?>
    <?php echo Html::endTag('div'); ?>
    <?php endforeach; ?>
</div>
<?php echo ElementListPagination::widget([
    'pagination' => $elementsProvider->pagination,
    'additionalLinkOptions' => $additionalLinkOptions
]); ?>
