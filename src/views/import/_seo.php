<?php
/**
 * _seo.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\import\composite
 *
 * @var $seo array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\BlackcubeHtml;

?>

<?php if (isset($seo) === true && is_array($seo)): ?>
    <div class="element-form-bloc-stacked">
        <?php echo BlackcubeHtml::checkbox('seoActive', $seo['active'] , [
            'hint' => Module::t('import', 'Seo status'),
            'label' => Module::t('import', 'Seo active'),
            'disabled' => 'disabled'
        ]); ?>
    </div>
    <div class="element-form-bloc-grid-12">
        <div class="element-form-bloc-cols-6">
            <?php echo BlackcubeHtml::checkbox('seoNoindex', $seo['noindex'] , [
                'hint' => Module::t('import', 'No index'),
                'label' => Module::t('import', 'No index'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
        <div class="element-form-bloc-cols-6">
            <?php echo BlackcubeHtml::checkbox('seoNofollow', $seo['nofollow'] , [
                'hint' => Module::t('import', 'No follow'),
                'label' => Module::t('import', 'No follow'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    </div>
    <!-- div class="element-form-bloc-grid-12">
        <div class="element-form-bloc-cols-12">
            <?php //echo BlackcubeHtml::activeDropDownList($seo, 'canonicalSlugId', ArrayHelper::map($availableSlugs, 'id', 'path'), ['label' => Module::t('common', 'Canonical Slug')]); ?>
        </div>
    </div -->
    <div class="element-form-bloc-stacked">
        <?php echo BlackcubeHtml::input('text', 'seoTitle', $seo['title'],  [
            'label' => Module::t('import', 'Title'),
            'disabled' => 'disabled'
        ]); ?>
        <?php echo BlackcubeHtml::input('textarea', 'seoDescription', $seo['description'],  [
            'label' => Module::t('import', 'Description'),
            'rows' => 4,
            'disabled' => 'disabled'
        ]); ?>
    </div>
    <?php if(empty($seo['image']) === false): ?>
        <div class="element-form-bloc-stacked">
            <img class="object-contain h-24" src="<?php echo preg_replace(
                    [
                            '/data:base64:([^.]+)\.(jpe?g):/',
                            '/data:base64:([^.]+)\.([^:]+):/',
                    ],
                    [
                            'data:image/jpeg;base64, ',
                            'data:image/$2;base64, ',
                    ], $seo['image']); ?>" >
        </div>
    <?php endif; ?>
    <div class="element-form-bloc-grid-12">
        <div class="element-form-bloc-cols-4">
            <?php echo BlackcubeHtml::checkbox('seoOg', $seo['og'] , [
                'hint' => Module::t('import', 'OG'),
                'label' => Module::t('import', 'OG'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
        <div class="element-form-bloc-cols-8">
            <?php echo BlackcubeHtml::dropDownList('seoOgType', $seo['ogType'], ['website' => Module::t('common', 'Website')], [
                'prompt' => Module::t('import', 'OG Type'),
                'label' => Module::t('import', 'OG Type'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    </div>
    <div class="element-form-bloc-grid-12">
        <div class="element-form-bloc-cols-4">
            <?php echo BlackcubeHtml::checkbox('seoTwitter', $seo['twitter'] , [
                'hint' => Module::t('import', 'Twitter'),
                'label' => Module::t('import', 'Twitter'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
        <div class="element-form-bloc-cols-8">
            <?php echo BlackcubeHtml::dropDownList('seotwitterCard', $seo['twitterCard'], ['summary' => Module::t('common', 'Summary'), 'summary_large_image' => Module::t('common', 'Summary large image')], [
                'prompt' => Module::t('import', 'Twitter Card'),
                'label' => Module::t('import', 'Twitter Card'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    </div>
<?php endif; ?>