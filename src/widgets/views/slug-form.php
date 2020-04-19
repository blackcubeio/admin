<?php
/**
 * slug-form.php
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
 * @var $slugForm blackcube\admin\models\SlugForm
 * @var $slug blackcube\core\models\Slug
 * @var $sitemap blackcube\core\models\Sitemap
 * @var $seo blackcube\core\models\Seo
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\models\Parameter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use Yii;

$elementClass = get_class($slugForm->getElement());
//TODO: move into SlugForm
$elementType = $elementClass::getElementType();
// $elementType = Inflector::camel2id(StringHelper::basename(get_class($slugForm->getElement())));

?>
<?php echo Html::beginTag('div', ['blackcube-toggle-slug' => ($slugForm->getElement()->id === null)?'':$elementType.'-'.$slugForm->getElement()->id]); ?>
    <div class="bloc mb-2">
        <div class="bloc-title flex justify-between">
            <div class="inline-block">
            <?php echo Html::activeCheckbox($slugForm, 'hasSlug', ['class' => 'mr-2 toggle', 'label' => false]); ?>
            <span class="title">
                <?php echo Module::t('widgets', 'Slug'); ?>
            </span>
            </div>
            <i class="fa fa-chevron-down text-white mt-2"></i>
        </div>
    </div>
    <div class="toggle-target hidden">
        <?php echo Html::activeHiddenInput($slugForm, 'openedSlug', ['class' => 'slug-status']); ?>
        <div class="bloc">
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
                <?php echo Html::activeLabel($slug, 'path', ['class' => 'label']); ?>
                <?php echo Html::activeTextInput($slug, 'path', ['class' => 'textfield'.($slug->hasErrors('path')?' error':'')]); ?>
            </div>
        </div>
        <div class="bloc">
            <div class="w-full px-3">
            <span class="italic text-xs text-gray-700"><?php echo Module::t('widgets', 'Sitemap and SEO elements are Slug dependant. They will be activated for the website only if Slug is active'); ?></span>
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
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'noindex', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'noindex', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'nofollow', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'nofollow', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-9/12">
                <?php echo Html::activeLabel($seo, 'title', ['class' => 'label']); ?>
                <?php echo Html::activeTextInput($seo, 'title', ['class' => 'textfield'.($seo->hasErrors('title')?' error':'')]); ?>
            </div>
        </div>
        <div class="bloc ml-4 justify-end">
            <div class="w-full bloc-fieldset md:w-11/12">
                <?php echo Html::activeLabel($seo, 'description', ['class' => 'label']); ?>
                <?php echo Html::activeTextarea($seo, 'description', ['class' => 'textfield'.($seo->hasErrors('description')?' error':'')]); ?>
            </div>
        </div>
        <div class="bloc ml-4 justify-end">
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($seo, 'image', ['class' => 'label']); ?>
                <?php echo Html::activeUpload($seo, 'image', [
                        'upload-url' => Url::to(['upload']),
                        'preview-url' => Url::to(['preview', 'name' => '__name__']),
                        'delete-url' => Url::to(['delete', 'name' => '__name__']),
                        'image-width' => 1200,
                        'image-height' => 630,
                        'file-type' => 'jpg,png',
                ]); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-7/12">
                <span class="italic text-xs text-gray-700"><?php echo Module::t('widgets', 'Image size should be 1200x630'); ?></span>
            </div>
        </div>
        <div class="bloc ml-4 justify-end">
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'og', ['class' => 'label']); ?>
                <?php echo Html::activeCheckbox($seo, 'og', ['label' => false, 'class' => 'checkbox']); ?>
            </div>
            <div class="w-full bloc-fieldset md:w-4/12">
                <?php echo Html::activeLabel($seo, 'ogType', ['class' => 'label']); ?>
                <div class="dropdown">
                    <?php echo Html::activeDropDownList($seo, 'ogType', ['siteweb' => Module::t('widgets', 'Website')]); ?>
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
    </div>
<?php echo Html::endTag('div'); ?>
