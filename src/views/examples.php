<?php
?>

<?php echo BlackcubeHtml::activeCheckbox($composite, 'active', ['hint' => 'Get notified when someo']); ?>
<div class="element-form-bloc-checkbox-wrapper">
    <div class="element-form-bloc-checkbox-input-wrapper">
        <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="element-form-bloc-checkbox error">
    </div>
    <div class="element-form-bloc-checkbox-label-wrapper">
        <label for="comments" class="element-form-bloc-label error">Comments</label>
        <p id="comments-description" class="element-form-bloc-abstract">Get notified when someones posts a comment on a posting.</p>
    </div>
</div>
<?php echo BlackcubeHtml::activeRadio($composite, 'active', ['hint' => 'Get notified when someo']); ?>
<div class="element-form-bloc-radio-wrapper">
    <div class="element-form-bloc-radio-input-wrapper">
        <input id="comments2" aria-describedby="comments-description2" name="comments2" type="radio" class="element-form-bloc-radio error">
    </div>
    <div class="element-form-bloc-radio-label-wrapper">
        <label for="comments2" class="element-form-bloc-label error">Comments</label>
        <p id="comments-description2" class="element-form-bloc-abstract">Get notified when someones posts a comment on a posting.</p>
    </div>
</div>
<?php echo BlackcubeHtml::activeDropDownList($nodeComposite, 'nodeId', ArrayHelper::map($nodesQuery->select(['id', 'name', 'level'])->asArray()->all(), 'id', function($item) {
    $level = (int)$item['level'];
    $finalName = $item['name'];
    for ($i = 1; $i < $level; $i++) {
        $finalName = '  '.$finalName;
    }
    return $finalName;
}), [
    'prompt' => Module::t('composite', 'Orphan'),
    'encodeSpaces' => true,
]); ?>
<div class="element-form-bloc-select-wrapper">
    <label for="location" class="element-form-bloc-label error">Location</label>
    <select id="location" name="location" class="element-form-bloc-select error">
        <option>United States</option>
        <option selected="">Canada</option>
        <option>Mexico</option>
    </select>
    <p class="element-form-bloc-abstract" id="email-description">We'll only use this for spam.</p>
</div>
<?php echo BlackcubeHtml::activeDateInput($composite, 'activeDateStart', ['realAttribute' => 'dateStart', 'hint' => 'Get notified when someo']); ?>
<?php echo BlackcubeHtml::activeTextInput($composite, 'name', ['hint' => 'Get notified when someo']); ?>
<div class="element-form-bloc-textfield-wrapper">
    <label for="email" class="element-form-bloc-label error">Email</label>
    <div class="element-form-bloc-textfield-input-wrapper">
        <input type="email" name="email" id="email" class="element-form-bloc-textfield error" placeholder="you@example.com" aria-describedby="email-description">
    </div>
    <p class="element-form-bloc-abstract" id="email-description">We'll only use this for spam.</p>
</div>
<?php echo BlackcubeHtml::activeTextarea($composite, 'name', ['rows' => 5, 'hint' => 'Get notified when someo']); ?>
<div class="element-form-bloc-textarea-wrapper">
    <label for="comment" class="element-form-bloc-label error">Add your comment</label>
    <div class="element-form-bloc-textarea-input-wrapper">
        <textarea rows="4" name="comment" id="comment" class="element-form-bloc-textarea error"></textarea>
    </div>
    <p class="element-form-bloc-abstract" id="email-description">We'll only use this for spam.</p>
</div>
<?php // echo BlackcubeHtml::activeUpload($composite, 'name', ['abstract' => 'Get notified when someo']); ?>
<?php echo BlackcubeHtml::activeUpload($composite->slug->seo, 'image', [
    'upload-url' => Url::to(['file-upload']),
    'preview-url' => Url::to(['file-preview', 'name' => '__name__']),
    'delete-url' => Url::to(['file-delete', 'name' => '__name__']),
    'image-width' => 1200,
    'image-height' => 630,
    'file-type' => 'jpg,png',
]); ?>
<div class="element-form-bloc-upload-wrapper">
    <label for="cover-photo" class="element-form-bloc-label error">
        Cover photo
    </label>
    <div class="element-form-bloc-upload-input-wrapper">
        <div class="element-form-bloc-upload-drop error">
            <div class="element-form-bloc-upload-drop-wrapper">
                <svg class="element-form-bloc-upload-icon" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <div class="element-form-bloc-upload-drop-input-wrapper">
                    <label for="file-upload" class="element-form-bloc-upload-drop-input-label">
                        <span>Upload a file</span>
                        <input id="file-upload" name="file-upload" type="file" class="sr-only">
                    </label>
                    <p class="element-form-bloc-upload-drop-input-accessory">or drag and drop</p>
                </div>
                <p class="element-form-bloc-abstract">
                    PNG, JPG, GIF up to 10MB
                </p>
            </div>
        </div>
    </div>
    <p class="element-form-bloc-abstract" id="email-description">We'll only use this for spam.</p>
</div>

<label class="block text-sm font-medium leading-6 text-gray-900">Contenu cible</label>
<div class="relative mt-2">
    <input data-form-dropdown="input" type="text" class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" role="combobox" aria-controls="options" aria-expanded="false">
    <button data-form-dropdown="button" type="button" tabindex="-1" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
        <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M10.53 3.47a.75.75 0 0 0-1.06 0L6.22 6.72a.75.75 0 0 0 1.06 1.06L10 5.06l2.72 2.72a.75.75 0 1 0 1.06-1.06l-3.25-3.25Zm-4.31 9.81 3.25 3.25a.75.75 0 0 0 1.06 0l3.25-3.25a.75.75 0 1 0-1.06-1.06L10 14.94l-2.72-2.72a.75.75 0 0 0-1.06 1.06Z" clip-rule="evenodd" />
        </svg>
    </button>

    <ul data-form-dropdown="panel" class="hidden absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
        <template>
            <!--
              Combobox option, manage highlight styles based on mouseenter/mouseleave and keyboard navigation.

              Active: "text-white bg-indigo-600", Not Active: "text-gray-900"
            -->
            <li data-form-dropdown="option">
                <button type="button" data-form-dropdown="option-button" tabindex=-1" class="w-full text-left group relative py-2 pl-8 pr-4 text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer">
                    <!-- Selected: "font-semibold" -->
                    <span class="block truncate" data-value=""></span>
                    <!--
                      Checkmark, only display for selected option.

                      Active: "text-white", Not Active: "text-indigo-600"
                    -->
                    <span data-selected="" class="absolute inset-y-0 left-0 flex items-center pl-1.5 text-indigo-600 group-hover:text-white">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                            </svg>
                        </span>
                </button>
            </li>
        </template>
    </ul>
</div>
<li data-form-dropdown="option" data-search-value="comment se calcule le montant de ma retraite dans le secteur prive ?">
    <button type="button" class="w-full text-left group relative py-2 pl-8 pr-4 text-gray-900 hover:text-white hover:bg-indigo-600 cursor-pointer" data-form-dropdown="option-button" tabindex="-1" role="option" data-option-id="/blackcube/composite-167" aria-selected="false" data-dashlane-label="true" data-dashlane-rid="0f67a799b29f9b7c" data-dashlane-classification="other">
        <span class="flex justify-start gap-2"><span class="block truncate font-bold max-w-sm" data-value-prefix="">Calculer ma retraite</span><span> / </span><span class="block truncate" data-value="">Comment se calcule le montant de ma retraite dans le secteur privé ?</span></span>
        <span class="absolute inset-y-0 left-0 flex items-center pl-1.5 text-indigo-600 group-hover:text-white hidden" data-selected="false"><svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd"></path></svg></span>
    </button>
</li>