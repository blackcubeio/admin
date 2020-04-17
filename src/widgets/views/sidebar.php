<?php
/**
 * sidebar.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets\views
 *
 * @var string $controller
 */

use blackcube\admin\Module;
use blackcube\admin\components\Rbac;
use blackcube\admin\helpers\Html;
use yii\helpers\Url;
?>
<!--Sidebar-->
<aside id="sidebar" blackcube-sidebar="">
    <ul>
        <?php  if (Yii::$app->user->can(Rbac::PERMISSION_SITE_DASHBOARD)): ?>
        <?php echo Html::beginTag('li', ['class' => ($controller === 'default' ? 'active':'')]); ?>
            <?php echo Html::beginTag('a', ['href' => Url::to(['default/index'])]); ?>
                <i class="fas fa-tachometer-alt float-left mx-2 mt-1"></i>
                <span><?php echo Module::t('widgets', 'Dashboard'); ?></span>
                <span><i class="fas fa-angle-right float-right mt-2"></i></span>
            <?php echo Html::endTag('a'); ?>
        <?php echo Html::endTag('li'); ?>
        <?php endif; ?>
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_USER_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_TYPE_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_VIEW)): ?>

            <li class="child">
                <?php echo Html::beginTag('span', ['class' => 'section', 'data-blackcube-section' => 'parameters']); ?>
                    <i class="fa fa-tools float-left mx-2 mt-2"></i>
                    <?php echo Module::t('widgets', 'Parameters'); ?>
                    <span><i class="fa fa-angle-down float-right mt-2 arrow"></i></span>
                <?php echo Html::endTag('span'); ?>
                <ul class="hidden">
                    <?php  if (Yii::$app->user->can(Rbac::PERMISSION_PARAMETER_VIEW)): ?>
                        <?php echo Html::beginTag('li', ['class' => ($controller === 'parameter' ? 'active':'')]); ?>
                            <?php echo Html::beginTag('a', ['href' => Url::to(['parameter/index'])]); ?>
                                <i class="fa fa-wrench float-left mx-2 mt-2"></i>
                                <?php echo Module::t('widgets', 'Parameters'); ?>
                                <span><i class="fa fa-angle-right angle"></i></span>
                            <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_USER_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'user' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['user/index'])]); ?>
                            <i class="fa fa-user-alt float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Users'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_TYPE_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'type' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['type/index'])]); ?>
                            <i class="fa fa-file-invoice float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Types'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_BLOCTYPE_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'bloc-type' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['bloc-type/index'])]); ?>
                            <i class="fa fa-cube float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Bloc types'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
        <?php if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)
            || Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)): ?>
        <li>
            <?php echo Html::beginTag('span', ['class' => 'section', 'data-blackcube-section' => 'management']); ?>
            <i class="fa fa-book float-left mx-2 mt-2"></i>
            <?php echo Module::t('widgets', 'Management'); ?>
            <span><i class="fa fa-angle-down float-right mt-2 arrow"></i></span>
            <?php echo Html::endTag('span'); ?>
            <ul class="hidden">
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_COMPOSITE_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'composite' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['composite/index'])]); ?>
                            <i class="fa fa-file float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Composites'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_NODE_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'node' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['node/index'])]); ?>
                            <i class="fa fa-sitemap float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Nodes'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_CATEGORY_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'category' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['category/index'])]); ?>
                            <i class="fas fa-tags float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Categories'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
                <?php  if (Yii::$app->user->can(Rbac::PERMISSION_TAG_VIEW)): ?>
                    <?php echo Html::beginTag('li', ['class' => ($controller === 'tag' ? 'active':'')]); ?>
                        <?php echo Html::beginTag('a', ['href' => Url::to(['tag/index'])]); ?>
                            <i class="fa fa-tag float-left mx-2 mt-2"></i>
                            <?php echo Module::t('widgets', 'Tags'); ?>
                            <span><i class="fa fa-angle-right angle"></i></span>
                        <?php echo Html::endTag('a'); ?>
                    <?php echo Html::endTag('li'); ?>
                <?php endif; ?>
            </ul>
        </li>
        <?php endif; ?>
    </ul>

</aside>
<!--/Sidebar-->
