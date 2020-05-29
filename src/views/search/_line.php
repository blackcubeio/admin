<?php
/**
 * _line.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\search
 *
 * @var $elementsQuery \blackcube\core\models\FilterActiveQuery
 * @var $elementType string
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
use yii\helpers\Url;

$formatter = Yii::$app->formatter;
if ($elementType === Node::getElementType()) {
    $controller = 'node';
    $name = Module::t('search', 'Nodes');
} elseif ($elementType === Composite::getElementType()) {
    $name = Module::t('search', 'Composites');
    $controller = 'composite';
} elseif ($elementType === Category::getElementType()) {
    $name = Module::t('search', 'Categories');
    $controller = 'category';
} elseif ($elementType === Tag::getElementType()) {
    $name = Module::t('search', 'Tags');
    $controller = 'tag';
} elseif ($elementType === Slug::getElementType()) {
    $name = Module::t('search', 'Slugs');
    $controller = 'slug';
}

?>

<?php foreach ($elementsQuery->each() as $element): ?>
    <?php /* @var \blackcube\core\models\Node|\blackcube\core\models\Composite|\blackcube\core\models\Category|\blackcube\core\models\Tag|\blackcube\core\models\Slug $element */ ?>
    <?php
    ?>
    <?php echo Html::beginTag('tr',[]); ?>
        <td>
            <div class="flex items-start">
                <?php echo Html::beginTag('div', ['class' => 'text-gray-900']); ?>
                    <div>
                        <?php if ($element instanceof Slug): ?>
                            <?php echo Html::a($element->path, [$controller.'/edit', 'id' => $element->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        <?php else: ?>
                            <?php echo Html::a($element->name, [$controller.'/edit', 'id' => $element->id], ['class' => 'hover:text-blue-600 py-1']); ?>
                        <?php endif; ?>
                        <span class="text-xs text-gray-600 italic">#<?php echo $element->id; ?></span>
                        <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category): ?>
                            <span class="text-xs text-gray-600 italic">(<?php echo $element->language->id; ?>)</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category || $element instanceof Tag): ?>
                        <?php if ($element->slug !== null): ?>
                            <div>
                                    <span class="text-xs text-gray-600  px-2 py-0 italic border bg-gray-100 border-gray-300 rounded">
                                        <?php echo $element->slug->path; ?>
                                    </span>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($element instanceof Node || $element instanceof Composite): ?>
                        <?php if (($element->dateStart !== null) || ($element->dateEnd !== null)): ?>
                        <div>
                            <span class="text-xs text-gray-600 italic ml-2">
                                <?php if ($element->dateStart !== null): ?>
                                    <?php echo Module::t('search', 'Start: {0,date,medium}', [$element->activeDateStart]); ?>

                                <?php endif; ?>
                                <?php if ($element->dateEnd !== null): ?>
                                    <?php echo Module::t('search', 'End: {0,date,medium}', [$element->activeDateEnd]); ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php echo Html::endTag('div'); ?>
            </div>
        </td>
        <td>
            <span class="text-xs text-gray-600 italic uppercase">
            <?php if ($element instanceof Node): ?>
                <?php echo Module::t('search', 'Node'); ?>
            <?php elseif ($element instanceof Composite): ?>
                <?php echo Module::t('search', 'Composite'); ?>
            <?php elseif ($element instanceof Category): ?>
                <?php echo Module::t('search', 'Category'); ?>
            <?php elseif ($element instanceof Tag): ?>
                <?php echo Module::t('search', 'Tag'); ?>
            <?php elseif ($element instanceof Slug): ?>
                <?php echo Module::t('search', 'Slug'); ?>
            <?php endif; ?>
            </span>
            <?php if ($element instanceof Node || $element instanceof Composite || $element instanceof Category || $element instanceof Tag): ?>
                <?php if ($element->type !== null): ?>
                    <span class="text-xxs text-gray-600 italic uppercase">(<?php echo $element->type->name; ?>)</span>
                <?php endif; ?>
            <?php endif; ?>
        </td>
        <td>
            <?php echo Publication::widget(['element' => $element]); ?>
        </td>
        <td>
            <?php echo Html::a('<i class="fa fa-pen-alt"></i>', [$controller.'/edit', 'id' => $element->id], ['class' => 'button']); ?>
            <?php echo Html::tag('span', $element->active?'<i class="fa fa-play"></i>':' <i class="fa fa-pause"></i>', [
                'class' => 'button no-action '.($element->active ? 'published' : 'draft')]); ?>
            <?php if ($element instanceof Slug): ?>
                <?php echo Html::a('<i class="fa fa-globe-americas"></i>', [$element->getRoute()], [
                    'class' => 'button',
                    'target' => '_blank',
                ]); ?>
            <?php elseif ($element->slug !== null): ?>
                <?php echo Html::a('<i class="fa fa-globe-americas"></i>', [$element->getRoute()], [
                    'class' => 'button',
                    'target' => '_blank',
                ]); ?>
            <?php else: ?>
                <span class="button disabled"><i class="fa fa-globe-americas"></i></span>
            <?php endif; ?>
        </td>
    <?php echo Html::endTag('tr'); ?>
<?php endforeach; ?>
