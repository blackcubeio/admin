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

