<?php
/**
 * form.php
 *
 * PHP version 7.2+
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
use blackcube\admin\widgets\Sidebar;
use blackcube\admin\widgets\SlugForm;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginAdminHookInterface;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;
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
        <?php echo Heroicons::svg('solid/chevron-left', ['class' => 'h-7 w-7']); ?>
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
                'slugExists.bind' => ($node->slug !== null)
            ]); ?>
        <?php endif; ?>
        <!-- p class="element-form-header-abstract"><?php echo Module::t('node', 'This is the minimal information needed to create a new node'); ?></p -->
    </div>
    <div class="px-6 pb-6">
        <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $node->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_HEAD : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_HEAD,
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
            $node->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_BEFORE_BLOCS : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_BEFORE_BLOCS,
            $node
        ); ?>
        <?php foreach ($widgets as $widget): ?>
            <?php echo $widget; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (($node->isNewRecord === false) && $node->type !== null): ?>
        <div class="element-form-header">
            <h3 class="element-form-header-title">
                <?php echo Module::t('node', 'Content'); ?>
            </h3>

        </div>
        <?php echo Aurelia::component('blackcube-blocs', '', [
            'url.bind' => Url::to(['blocs', 'id' => $node->id]),
            'view.bind' => $this->render('@blackcube/admin/views/common/_blocs', [
                'element' => $node,
                'blocs' => $blocs
            ])
        ]);?>
        <div class="element-form-header mt-6">
            <h3 class="element-form-header-title">
                <?php echo Module::t('node', 'Composites'); ?>
            </h3>

        </div>
        <?php echo Aurelia::component('blackcube-composites', '', [
            'url.bind' => Url::to(['composites', 'id' => $node->id]),
            'view.bind' => $this->render('@blackcube/admin/views/common/_composites', [
                'element' => $node,
            ])
        ]);?>
    <?php endif; ?>

    <?php if ($pluginsHandler instanceof PluginsHandlerInterface): ?>
            <?php $widgets = $pluginsHandler->runWidgetHook(
                $node->isNewRecord ? PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_CREATE_TAIL : PluginAdminHookInterface::PLUGIN_HOOK_WIDGET_NODE_UPDATE_TAIL,
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
