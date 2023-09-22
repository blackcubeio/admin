<?php
/**
 * form.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\views\node
 *
 * @var $pluginsHandler \blackcube\core\interfaces\PluginsHandlerInterface
 * @var $node \blackcube\core\models\Node
 * @var $typesQuery \blackcube\core\models\FilterActiveQuery
 * @var $languagesQuery \blackcube\core\models\FilterActiveQuery
 * @var $targetNodesQuery \blackcube\core\models\FilterActiveQuery
 * @var $compositesQuery \blackcube\core\models\FilterActiveQuery
 * @var $blocs \blackcube\core\models\Bloc[]
 * @var $moveNodeForm \blackcube\admin\models\MoveNodeForm
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;
use blackcube\core\models\Tag;
?>
<main class="application-content">
    <?php echo Html::beginForm('', 'post', [
        'class' => 'element-form-wrapper',
    ]); ?>
    <div class="page-header">
        <?php echo Html::beginTag('a', [
            'class' => 'text-white',
            'href' => Url::to(['index'])
        ]); ?>
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-5 w-5 mr-2']); ?>
        <?php echo Html::endTag('a'); ?>
        <h3 class="page-header-title"><?php echo Module::t('node', 'Node'); ?></h3>
        <?php if($node->isNewRecord === false): ?>
            <?php echo Aurelia::component('blackcube-element-toolbar', '', [
                'slugTitle.bind' => Module::t('node', 'Slug'),
                'slugUrl.bind' => Url::to(['slug', 'id' => $node->id]),
                'slugActive.bind' => (($node->slug !== null) && $node->slug->active),
                'sitemapTitle.bind' => Module::t('node', 'Sitemap'),
                'sitemapUrl.bind' => Url::to(['sitemap', 'id' => $node->id]),
                'sitemapActive.bind' => (($node->slug !== null) && ($node->slug->sitemap !== null) && $node->slug->sitemap->active),
                'seoTitle.bind' => Module::t('node', 'SEO'),
                'seoUrl.bind' => Url::to(['seo', 'id' => $node->id]),
                'seoActive.bind' => (($node->slug !== null) && ($node->slug->seo !== null) && $node->slug->seo->active),
                'tagsTitle.bind' => Module::t('node', 'Tags'),
                'tagsUrl.bind' => Url::to(['tag', 'id' => $node->id]),
                'showTags.bind' => (Tag::find()->count() > 0),
                'slugExists.bind' => ($node->slug !== null)
            ]); ?>
        <?php endif; ?>
        <!-- p class="element-form-header-abstract"><?php echo Module::t('node', 'This is the minimal information needed to create a new node'); ?></p -->
    </div>
    <div class="px-6 pb-6">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $node->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_HEAD : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_HEAD,
                $node
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="element-form-bloc">
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::activeCheckbox($node, 'active', ['hint' => Module::t('node', 'Node status')]); ?>
            </div>
            <?php if($node->isNewRecord === true): ?>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDateInput($node, 'activeDateStart', ['realAttribute' => 'dateStart']); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDateInput($node, 'activeDateEnd', ['realAttribute' => 'dateEnd']); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($node, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'prompt' => Module::t('composite', 'No type'),
                        'label' => Module::t('node', 'Type'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeDropDownList($node, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                        'label' => Module::t('node', 'Language'),
                    ]); ?>
                </div>
            </div>
            <div class="element-form-bloc-grid-12" blackcube-toggle-dependencies="">
                <div class="element-form-bloc-cols-3">
                    <?php
                        $options = ['data-dependency-source' => ''];
                        if($node->isNewRecord) {
                            $moveNodeForm->move = 1;
                            $options['disabled'] = 'disabled';
                        }
                    ?>
                    <?php echo BlackcubeHtml::activeCheckbox($moveNodeForm, 'move', $options); ?>
                </div>
                <div class="element-form-bloc-cols-6" data-dependency="">
                    <?php echo BlackcubeHtml::activeDropDownList($moveNodeForm, 'mode', [
                        'into' => Module::t('node', 'Into'),
                        'before' => Module::t('node', 'Before'),
                        'after' => Module::t('node', 'After'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-3" data-dependency="">
                    <?php echo BlackcubeHtml::activeDropDownList($moveNodeForm, 'target', $mapNodes = ArrayHelper::map(
                                $targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                                'id',
                                function($item) {
                                    return str_repeat('-', ($item['level'] - 1)).' '.$item['name'];
                                }), [
                                    'options' =>ArrayHelper::map($targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                                    'id',
                                        function($item) use ($node) {
                                            $option = [
                                                'label' => str_repeat('-', ($item['level'] - 1)).' '.$item['name'],
                                            ];
                                            if (empty($node->left) === false && $item['left'] >= $node->left && empty($node->right) === false && $item['right'] <= $node->right ) {
                                                $option['disabled'] = 'disabled';
                                            }
                                            return $option;
                                        }),
                                    'prompt' => Module::t('node', 'Target node'),
                    ]); ?>
                </div>
            </div>
            <?php else: ?>
            <div blackcube-view-edit="">
                <div class="element-form-bloc-grid-12">
                    <div class="element-form-bloc-cols-3 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDateInput($node, 'activeDateStart', ['realAttribute' => 'dateStart']); ?>
                    </div>
                    <div class="element-form-bloc-cols-3" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo $node->getAttributeLabel('dateStart'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo Yii::$app->formatter->asDate($node->dateStart); ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-3 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDateInput($node, 'activeDateEnd', ['realAttribute' => 'dateEnd']); ?>
                    </div>
                    <div class="element-form-bloc-cols-3" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo $node->getAttributeLabel('dateEnd'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo Yii::$app->formatter->asDate($node->dateEnd); ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-3 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDropDownList($node, 'typeId', ArrayHelper::map($typesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'prompt' => Module::t('node', 'No type'),
                            'label' => Module::t('node', 'Type'),
                        ]); ?>
                    </div>
                    <div class="element-form-bloc-cols-3" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo Module::t('node', 'Type'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo $node->type?->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-3 hidden" data-view-edit="edit">
                        <?php echo BlackcubeHtml::activeDropDownList($node, 'languageId', ArrayHelper::map($languagesQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                            'label' => Module::t('node', 'Language'),
                        ]); ?>
                    </div>
                    <div class="element-form-bloc-cols-2" data-view-edit="view">
                        <div class="element-form-bloc-textfield-wrapper">
                            <label class="element-form-bloc-label"><?php echo Module::t('node', 'Language'); ?></label>
                            <div class="element-form-bloc-abstract">
                                <?php echo $node->language?->name ?>
                            </div>
                        </div>
                    </div>
                    <div class="element-form-bloc-cols-1" data-view-edit="toggle">
                        <button type="button" class="relative inline-flex items-center p-2.5 rounded-md bg-white text-sm font-medium text-gray-500 hover:text-white hover:bg-indigo-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php echo Heroicons::svg('solid/pencil-square', ['class' => 'h-4 w-4']); ?>
                        </button>
                    </div>
                </div>
                <div class="element-form-bloc-grid-12 hidden" blackcube-toggle-dependencies=""  data-view-edit="edit">
                    <div class="element-form-bloc-cols-3">
                        <?php
                        $options = ['data-dependency-source' => ''];
                        if($node->isNewRecord) {
                            $moveNodeForm->move = 1;
                            $options['disabled'] = 'disabled';
                        }
                        ?>
                        <?php echo BlackcubeHtml::activeCheckbox($moveNodeForm, 'move', $options); ?>
                    </div>
                    <div class="element-form-bloc-cols-6" data-dependency="">
                        <?php echo BlackcubeHtml::activeDropDownList($moveNodeForm, 'mode', [
                            'into' => Module::t('node', 'Into'),
                            'before' => Module::t('node', 'Before'),
                            'after' => Module::t('node', 'After'),
                        ]); ?>
                    </div>
                    <div class="element-form-bloc-cols-3" data-dependency="">
                        <?php echo BlackcubeHtml::activeDropDownList($moveNodeForm, 'target', $mapNodes = ArrayHelper::map(
                            $targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                            'id',
                            function($item) {
                                return str_repeat('-', ($item['level'] - 1)).' '.$item['name'];
                            }), [
                            'options' =>ArrayHelper::map($targetNodesQuery->select(['id', 'name', 'level', 'left', 'right'])->asArray()->all(),
                                'id',
                                function($item) use ($node) {
                                    $option = [
                                        'label' => str_repeat('-', ($item['level'] - 1)).' '.$item['name'],
                                    ];
                                    if (empty($node->left) === false && $item['left'] >= $node->left && empty($node->right) === false && $item['right'] <= $node->right ) {
                                        $option['disabled'] = 'disabled';
                                    }
                                    return $option;
                                }),
                            'prompt' => Module::t('node', 'Target node'),
                        ]); ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-9">
                    <?php echo BlackcubeHtml::activeTextInput($node, 'name'); ?>
                </div>
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::activeTextInput($node, 'path', ['disabled' => 'disabled']); ?>
                </div>
            </div>
        </div>
    </div>

    <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
        <?php $widgets = $pluginsHandler->runWidgetHook(
            $node->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_BEFORE_BLOCS : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_BEFORE_BLOCS,
            $node
        ); ?>
        <?php foreach ($widgets as $widget): ?>
            <?php echo $widget; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (($node->isNewRecord === false) && $node->type !== null): ?>
        <?php echo Html::beginTag('div', ['blackcube-fold' => Aurelia::bindOptions(['element-type' => $node::getElementType(), 'element-id' => $node->id, 'element-sub-data' => 'blocs'])]); ?>
            <div class="element-form-header flex justify-between text-white" data-fold="">
                <h3 class="element-form-header-title">
                    <?php echo Module::t('node', 'Contents'); ?>
                    <span class="inline-flex items-center ml-2 px-1 py-0.5 rounded-full text-xs font-medium bg-white text-indigo-800"> <?php echo $node->getBlocs()->count(); ?> </span>
                </h3>
                <button type="button" data-fold="down">
                    <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-5 w-5']); ?>
                </button>
                <button type="button" data-fold="up" class="hidden">
                    <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-5 w-5']); ?>
                </button>
            </div>
            <?php echo Aurelia::component('blackcube-blocs', '', [
                'data-target-fold' => '',
                'class' => 'hidden',
                'url.bind' => Url::to(['blocs', 'id' => $node->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                    'element' => $node,
                    'blocs' => $blocs
                ])
            ]);?>
        <?php echo Html::endTag('div'); ?>
        <?php echo Html::beginTag('div', ['blackcube-fold' => Aurelia::bindOptions(['element-type' => $node::getElementType(), 'element-id' => $node->id, 'element-sub-data' => 'composites'])]); ?>
            <div class="element-form-header mt-6 flex justify-between text-white" data-fold="">

                <h3 class="element-form-header-title">
                    <?php echo Module::t('node', 'Composites'); ?>
                    <span class="inline-flex items-center ml-2 px-1 py-0.5 rounded-full text-xs font-medium bg-white text-indigo-800"> <?php echo $node->getComposites()->count(); ?> </span>
                </h3>
                <button type="button" data-fold="up">
                    <?php echo Heroicons::svg('outline/chevron-up', ['class' => 'h-5 w-5']); ?>
                </button>
                <button type="button" class="hidden" data-fold="down">
                    <?php echo Heroicons::svg('outline/chevron-down', ['class' => 'h-5 w-5']); ?>
                </button>
            </div>
            <?php echo Aurelia::component('blackcube-composites', '', [
                'data-target-fold' => '',
                'class' => 'hidden',
                'url.bind' => Url::to(['composites', 'id' => $node->id]),
                'view.bind' => $this->render('@blackcube/admin/views/common/_composites', [
                    'element' => $node,
                ])
            ]);?>
        <?php echo Html::endTag('div'); ?>
    <?php endif; ?>

    <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $node->isNewRecord ? PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_TAIL : PluginManagerAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_TAIL,
                $node
            ); ?>
            <?php foreach ($widgets as $widget): ?>
                <?php echo $widget; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <div class="px-6 pb-6">
        <div class="element-form-buttons">
            <?php echo Html::beginTag('a', [
                'class' => 'element-form-buttons-button',
                'href' => Url::to(['index'])
            ]); ?>
            <?php echo Heroicons::svg('solid/x', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Cancel'); ?>
            <?php echo Html::endTag('a'); ?>
            <?php echo Html::beginTag('button', [
                'class' => 'element-form-buttons-button action',
                'type' => 'submit'
            ]); ?>
            <?php echo Heroicons::svg('solid/check', ['class' => 'element-form-buttons-button-icon']); ?>
            <?php echo Module::t('common', 'Save'); ?>
            <?php echo Html::endTag('button'); ?>
        </div>
    </div>
    <?php echo Html::endForm(); ?>
</main>
