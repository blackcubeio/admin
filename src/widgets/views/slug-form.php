<?php
/**
 * @var $slugForm blackcube\admin\models\SlugForm
 * @var $slug blackcube\core\models\Slug
 * @var $sitemap blackcube\core\models\Sitemap
 * @var $seo blackcube\core\models\Seo
 */
use blackcube\admin\helpers\Html;
use yii\helpers\ArrayHelper;
use blackcube\admin\helpers\Parameter;
?>
<?php echo Html::beginTag('div', ['toggle-slug' => ($slugForm->getElement()->id === null)?'':$slugForm->getElement()->id]); ?>
    <div class="bloc mb-2">
        <div class="bloc-title">
            <?php echo Html::activeCheckbox($slugForm, 'hasSlug', ['class' => 'mr-2 toggle', 'label' => false]); ?>
            <span class="title">Slug</span>
        </div>
    </div>
    <div class="toggle-target">
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
        <div class="bloc ml-4">
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($sitemap, 'active', ['class' => 'label', 'label' => 'Sitemap']); ?>
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
        <div class="bloc ml-4">
            <div class="w-full bloc-fieldset md:w-1/12">
                <?php echo Html::activeLabel($seo, 'active', ['class' => 'label', 'label' => 'Seo']); ?>
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
                    <label class="w-full flex flex-col items-center px-4 py-4 bg-white text-gray-600 rounded-lg text-sm tracking-wide uppercase border border-gray-400 cursor-pointer hover:bg-gray-100 hover:text-gray-800">
                        <svg class="w-8 h-8" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M16.88 9.1A4 4 0 0 1 16 17H5a5 5 0 0 1-1-9.9V7a3 3 0 0 1 4.52-2.59A4.98 4.98 0 0 1 17 8c0 .38-.04.74-.12 1.1zM11 11h3l-4-4-4 4h3v3h2v-3z" />
                        </svg>
                        <span class="mt-2 text-sm leading-normal">Select a file</span>
                        <input type='file' class="hidden" />
                    </label>
            </div>
            <div class="w-full bloc-fieldset md:w-7/12">
                Image place Holder
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
                    <?php echo Html::activeDropDownList($seo, 'ogType', ['type1' => 'type1']); ?>
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
                    <?php echo Html::activeDropDownList($seo, 'twitterCard', ['type1' => 'type1']); ?>
                    <div class="arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php echo Html::endTag('div'); ?>
