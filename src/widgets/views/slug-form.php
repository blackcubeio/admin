<?php
/**
 * slug-form.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets\views
 *
 * @var $slugForm blackcube\admin\models\SlugForm
 * @var $slug blackcube\core\models\Slug
 * @var $sitemap blackcube\core\models\Sitemap
 * @var $seo blackcube\core\models\Seo
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\models\Parameter;
use blackcube\core\models\Slug;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$elementClass = get_class($slugForm->getElement());
//TODO: move into SlugForm
$elementType = $elementClass::getElementType();

if ($elementType === \blackcube\core\models\Node::getElementType()) {
    $parentNode = $slugForm->getElement()->getParent()->one();
    if ($parentNode !== null) {
        $parentNodeId = $parentNode->id;
    }
}

$slugFormOptions = [];
if ($slugForm->isStandalone === false) {
    $slugFormOptions['blackcube-toggle-slug'] = ($slugForm->getElement()->id === null)?'':$elementType.'-'.$slugForm->getElement()->id;
}

?>
<?php echo Html::beginTag('div', $slugFormOptions); ?>
    <div class="bloc mb-2">
        <div class="bloc-title flex justify-between">
            <div class="inline-block">
            <?php if ($slugForm->isStandalone === false): ?>
                <?php echo Html::activeCheckbox($slugForm, 'hasSlug', ['class' => 'mr-2 toggle', 'label' => false]); ?>
            <?php endif; ?>
            <span class="title">
                <?php echo Module::t('widgets', 'Slug'); ?>
                <?php if ($slugForm->isStandalone && $slugForm->getIsRedirectSlug() === false): ?>
                    <span class="text-xs text-gray-200 italic pl-2">(<?php echo $slugForm->getElement()->name; ?>)</span>
                <?php endif; ?>
            </span>
            </div>
            <?php if ($slugForm->isStandalone === false): ?>
            <i class="fa fa-chevron-down text-white mt-2"></i>
            <?php endif; ?>
        </div>
    </div>

    <?php echo Html::beginTag('div', ['class' => ''.(($slugForm->isStandalone === false)?'toggle-target hidden':'')]); ?>
        <?php echo Html::activeHiddenInput($slugForm, 'openedSlug', ['class' => 'slug-status']); ?>
        <div class="bloc">
            <?php if ($slugForm->getIsRedirectSlug()): ?>
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($slug, 'active', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($slug, 'active', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-3/12">
                <?php echo Html::activeLabel($slug, 'host', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($slug, 'host', ArrayHelper::map(Parameter::getAllowedHosts(), 'id', 'value'), [
                    ]); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
                <div class="w-full bloc-fieldset md:w-8/12">
                    <div class="label">
                        <?php echo Html::activeLabel($slug, 'path', [/*/'class' => 'label'/**/]); ?>
                        <?php echo Html::a('<i class="fa fa-refresh"></i>', '', [
                            'class' => 'button rounded',
                        ]); ?>
                    </div>
                    <?php echo Html::activeTextInput($slug, 'path', ['class' => 'textfield'.($slug->hasErrors('path')?' error':'')]); ?>
                    <?php echo Html::a('<i class="fa fa-refresh"></i>', '', [
                        'class' => 'button rounded',
                    ]); ?>
                    <?php if (isset($parentNodeId)) :?>
                        <?php echo Html::hiddenInput('parentNodeId', $parentNodeId); ?>
                    <?php endif; ?>
                </div>


            <?php else: ?>
            <div class="w-full bloc-fieldset md:w-3/12">
                <?php echo Html::activeLabel($slug, 'host', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($slug, 'host', ArrayHelper::map(Parameter::getAllowedHosts(), 'id', 'value'), [
                    ]); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
                <div class="w-full bloc-fieldset md:w-9/12">
                    <div class="label">
                        <?php echo Html::activeLabel($slug, 'path', [/*/'class' => 'label'/**/]); ?>
                        <?php echo Html::a('<i class="fa fa-refresh"></i>', '', [
                            'class' => 'button rounded',
                            'blackcube-url-generator' => Url::toRoute('ajax/generate-slug')
                        ]); ?>
                        <?php if (isset($parentNodeId)) :?>
                            <?php echo Html::hiddenInput('parentNodeId', $parentNodeId); ?>
                        <?php endif; ?>
                    </div>
                    <?php echo Html::activeTextInput($slug, 'path', ['class' => 'textfield'.($slug->hasErrors('path')?' error':'')]); ?>
                </div>

            <?php endif; ?>
        </div>
        <?php if($slugForm->getIsRedirectSlug() === true): ?>
        <div class="bloc">
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($slug, 'httpCode', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($slug, 'httpCode', [
                        301 => Module::t('slug', 'Moved Permanently (#{code})', ['code' => 301]),
                        302 => Module::t('slug', 'Found (#{code})', ['code' => 302])
                    ], ['prompt' => Module::t('slug', 'Select HTTP Code'), 'class' => $slug->hasErrors('httpCode') ? 'error':'']); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full bloc-fieldset md:w-8/12">
                <?php echo Html::activeLabel($slug, 'targetUrl', ['class' => 'label']); ?>
                <?php echo Html::activeTextInput($slug, 'targetUrl', ['class' => 'textfield'.($slug->hasErrors('targetUrl')?' error':'')]); ?>
            </div>
        </div>
        <?php endif; ?>
        <div class="bloc">
            <div class="w-full px-3">
            <span class="italic text-xs text-gray-700"><?php echo Module::t('widgets', 'Sitemap and SEO are Slug dependant. They will be activated for the website only if Slug is active'); ?></span>
            </div>
        </div>
        <div class="bloc">
            <div class="bloc-subtitle">
                <label class="title"><?php echo Module::t('widgets', 'Sitemap'); ?></label>
            </div>
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($sitemap, 'active', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($sitemap, 'active', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-2/12">
                <?php echo Html::activeLabel($sitemap, 'frequency', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($sitemap, 'frequency', $slugForm->getFrequencies()); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full bloc-fieldset md:w-2/12">
                <?php echo Html::activeLabel($sitemap, 'priority', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($sitemap, 'priority', $slugForm->getPriorities()); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="bloc">
            <div class="bloc-subtitle">
                <label class="title"><?php echo Module::t('widgets', 'SEO'); ?></label>
            </div>
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'active', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'active', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-2/12">
                <?php echo Html::activeLabel($seo, 'noindex', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'noindex', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-9/12">
                <?php echo Html::activeLabel($seo, 'title', ['class' => 'label']); ?>
                <?php echo Html::activeTextInput($seo, 'title', ['class' => 'textfield'.($seo->hasErrors('title')?' error':'')]); ?>
            </div>
        </div>
        <div class="bloc justify-end">
            <div class="w-full bloc-fieldset md:w-2/12">
                <?php echo Html::activeLabel($seo, 'nofollow', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'nofollow', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-9/12">
                <?php echo Html::activeLabel($seo, 'description', ['class' => 'label']); ?>
                <?php echo Html::activeTextarea($seo, 'description', ['class' => 'textfield'.($seo->hasErrors('description')?' error':'')]); ?>
            </div>
        </div>
        <div class="bloc justify-end">
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($seo, 'image', ['class' => 'label']); ?>
                <?php echo Html::activeUpload($seo, 'image', [
                        'upload-url' => Url::to(['file-upload']),
                        'preview-url' => Url::to(['file-preview', 'name' => '__name__']),
                        'delete-url' => Url::to(['file-delete', 'name' => '__name__']),
                        'image-width' => 1200,
                        'image-height' => 630,
                        'file-type' => 'jpg,png',
                ]); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-5/12">
                <span class="italic text-xs text-gray-700"><?php echo Module::t('widgets', 'Image size should be 1200x630'); ?></span>
            </div>
        </div>
        <div class="bloc justify-end">
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'og', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'og', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($seo, 'ogType', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($seo, 'ogType', ['website' => Module::t('widgets', 'Website')]); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'twitter', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'twitter', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($seo, 'twitterCard', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($seo, 'twitterCard', ['summary' => Module::t('widgets', 'Summary'), 'summary_large_image' => Module::t('widgets', 'Summary large image')]); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    <?php echo Html::endTag('div'); ?>
<?php echo Html::endTag('div'); ?>
