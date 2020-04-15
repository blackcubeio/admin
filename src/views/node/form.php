<?php
/**
 * form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\node
 *
 * @var $node \blackcube\core\models\Node
 * @var $parentNode \blackcube\core\models\Node
 * @var $slugForm \blackcube\admin\models\SlugForm
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $targetNodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $tagBlocs \blackcube\core\models\TagBloc[]
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\SlugForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="flex flex-1">
    <?php echo Sidebar::widget(); ?>
    <main>
        <?php echo Html::beginForm('', 'post', ['class' => 'form']); ?>
        <ul class="header">
            <li>
                <?php echo Html::a('<i class="fa fa-angle-left mr-2"></i> '.Module::t('node', 'Back'), ['index'], ['class' => 'button']); ?>
            </li>
            <li>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('node', 'Save'), ['type' => 'submit', 'class' => 'button']); ?>
            </li>
        </ul>
            <?php echo SlugForm::widget([
                'element' => $node,
                'slugForm' => $slugForm,
            ]); ?>
            <div class="bloc">
                <div class="bloc-title">
                    <span class="title"><?php echo Module::t('node', 'Node'); ?></span>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::activeLabel($node, 'active', ['class' => 'label']); ?>
                    <?php echo Html::activeCheckbox($node, 'active', ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($node, 'dateStart', ['class' => 'label']); ?>
                    <?php echo Html::activeDateInput($node, 'activeDateStart', ['class' => 'textfield'.($node->hasErrors('dateStart')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($node, 'dateEnd', ['class' => 'label']); ?>
                    <?php echo Html::activeDateInput($node, 'activeDateEnd', ['class' => 'textfield'.($node->hasErrors('dateEnd')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12">
                    <?php echo Html::activeLabel($node, 'typeId', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($node, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => Module::t('node', 'No type'),
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-2/12">
                    <?php echo Html::activeLabel($node, 'languageId', ['class' => 'label']); ?>
                    <?php /*/ echo Html::activeDropDownList($tag, 'categoryId', ArrayHelper::map($categoriesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'blackcube-choices' => ''
                    ]); /**/?>
                    <div class="dropdown">
                        <?php echo Html::activeDropDownList($node, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bloc" blackcube-toggle-dependencies="">
                <div class="w-full bloc-fieldset md:w-1/12">
                    <?php echo Html::label(Module::t('node', 'Move Node'), 'moveNode', ['class' => 'label']); ?>
                    <?php echo Html::checkbox('moveNode', false, ['label' => false, 'class' => 'checkbox']); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-3/12" data-dependency="">
                    <?php echo Html::label(Module::t('node', 'Mode'), 'moveNodeMode', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php echo Html::dropDownList('moveNodeMode', null, [
                            'into' => Module::t('node', 'Into'),
                            'before' => Module::t('node', 'Before'),
                            'after' => Module::t('node', 'After'),
                        ]); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
                <div class="w-full bloc-fieldset md:w-8/12" data-dependency="">
                    <?php echo Html::label(Module::t('node', 'Target Node'), 'moveNodeTarget', ['class' => 'label']); ?>
                    <div class="dropdown">
                        <?php $mapNodes = ArrayHelper::map(
                                $targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                                'id',
                                function($item) {
                                    return str_repeat('-', ($item['level'] - 1)).' '.$item['name'];
                                });
                            $mapNodesOptions = ArrayHelper::map(
                                $targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                                'id',
                                function($item) use ($node) {
                                    $option = [
                                        'label' => str_repeat('-', ($item['level'] - 1)).' '.$item['name'],
                                    ];
                                    if (empty($node->left) === false && $item['left'] >= $node->left && empty($node->right) === false && $item['right'] <= $node->right ) {
                                        $option['disabled'] = 'disabled';
                                    }
                                    return $option;
                                });
                            $options = ['prompt' => Module::t('node', 'Target node'), 'options' => $mapNodesOptions];
                        ?>
                        <?php echo Html::dropDownList('moveNodeTarget', null, $mapNodes, $options); ?>
                        <div class="arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bloc">
                <div class="w-full bloc-fieldset md:w-10/12">
                    <?php echo Html::activeLabel($node, 'name', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($node, 'name', ['class' => 'textfield'.($node->hasErrors('name')?' error':'')]); ?>
                </div>
                <div class="w-full bloc-fieldset md:w-2/12">
                    <?php echo Html::activeLabel($node, 'path', ['class' => 'label']); ?>
                    <?php echo Html::activeTextInput($node, 'path', ['class' => 'textfield'.($node->hasErrors('name')?' error':''), 'disabled' => 'disabled']); ?>
                </div>
            </div>
            <?php echo Html::beginTag('div', ['blackcube-toggle-element' => Html::bindAureliaAttributes([
                'elementType' => \blackcube\core\models\Node::getElementType(),
                'elementId' => $node->id,
                'elementSubData' => 'tags'
            ])]); ?>
                <div class="bloc">
                    <div class="bloc-title flex justify-between" data-toggle-element="source">
                        <span class="title"><?php echo Module::t('node', 'Tags'); ?></span>
                        <i class="fa fa-chevron-down text-white mt-2"></i>
                    </div>
                </div>
                <div  data-toggle-element="target">
                    <div class="bloc">
                        <div class="w-full bloc-fieldset">
                            <?php echo Html::dropDownList('selectedTags', ArrayHelper::getColumn($node->tags, 'id'), ArrayHelper::map($selectTagsData, 'tagId', 'tagName', 'categoryName'), ['multiple' => 'multiple', 'blackcube-choices' => '']); ?>
                        </div>
                    </div>
                </div>
            <?php echo Html::endTag('div'); ?>

            <?php if ($node->id !== null && $node->type !== null): ?>
                <?php echo Html::beginTag('div', ['blackcube-toggle-element' => Html::bindAureliaAttributes([
                    'elementType' => \blackcube\core\models\Node::getElementType(),
                    'elementId' => $node->id,
                    'elementSubData' => 'blocs'
                ])]); ?>
                    <?php echo Html::beginTag('div', [
                        'blackcube-blocs' => Url::to(['blocs', 'id' => $node->id])
                    ]); ?>
                        <div class="bloc">
                            <div class="bloc-title flex justify-between" data-toggle-element="source">
                                <span class="title"><?php echo Module::t('node', 'Content'); ?></span>
                                <i class="fa fa-chevron-down text-white mt-2"></i>
                            </div>
                        </div>
                        <div data-toggle-element="target">
                            <div data-ajax-target="">
                                <?php echo $this->render('@blackcube/admin/views/common/_blocs', ['blocs' => $blocs, 'element' => $node]); ?>
                            </div>
                            <?php if ($node->type && $node->type->getBlocTypes()->count() > 0): ?>
                            <div class="bloc bloc-tools">
                                <div class="dropdown-tool">
                                    <?php echo Html::dropDownList('blocTypeId', null, ArrayHelper::map($node->type->blocTypes, 'id', 'name'), []); ?>
                                    <div class="dropdown-tool-arrow">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                    </div>
                                </div>
                                <button type="button" name="blocAdd" class="button">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" >
                                        <path d="M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5c0-1.1.9-2 2-2zm0 2v14h14V5H5zm8 6h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0v-2H9a1 1 0 0 1 0-2h2V9a1 1 0 0 1 2 0v2z"/>
                                    </svg>
                                </button>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php echo Html::endTag('div'); ?>
                <?php echo Html::endTag('div'); ?>

            <?php endif; ?>

        <?php echo Html::beginTag('div', ['blackcube-toggle-element' => Html::bindAureliaAttributes([
            'elementType' => \blackcube\core\models\Node::getElementType(),
            'elementId' => $node->id,
            'elementSubData' => 'composites'
        ])]); ?>
            <?php echo Html::beginTag('div', [
                'blackcube-composites' => Url::to(['composites', 'id' => $node->id])
            ]); ?>
                <div class="bloc">
                    <div class="bloc-title flex justify-between" data-toggle-element="source">
                        <span class="title"><?php echo Module::t('node', 'Composites'); ?></span>
                        <i class="fa fa-chevron-down text-white mt-2"></i>
                    </div>
                </div>
                <div data-toggle-element="target">
                    <div data-ajax-target="">
                        <?php echo $this->render('_composites', ['compositesQuery' => $compositesQuery, 'element' => $node]); ?>
                    </div>
                    <?php echo Html::tag('blackcube-search-composite', '', [
                        'search-url' => Url::to(['search', 'query' => '__query__']),
                    ]); ?>
                </div>
            <?php echo Html::endTag('div'); ?>
        <?php echo Html::endTag('div'); ?>

        <div class="buttons">
                <?php echo Html::a('<i class="fa fa-times mr-2"></i> '.Module::t('node', 'Cancel'), ['index'], [
                    'class' => 'button-cancel'
                ]); ?>
                <?php echo Html::button('<i class="fa fa-check mr-2"></i> '.Module::t('node', 'Save'), [
                    'type' => 'submit',
                    'class' => 'button-submit'
                ]); ?>
            </div>
        <?php echo Html::endForm(); ?>
    </main>
</div>
