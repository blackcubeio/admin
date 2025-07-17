<?php
/**
 * _tags.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $blocs array
 * @var $tagsQuery \yii\db\ActiveQuery
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\BlackcubeHtml;
use yii\helpers\ArrayHelper;

?>

<?php if (isset($tags) === true && is_array($tags)): ?>
    <?php foreach ($tags as $tagId): ?>
        <div class="element-form-bloc-stacked">
            <?php echo BlackcubeHtml::dropDownList('tagId[]',  $tagId, ArrayHelper::map($tagsQuery->select(['id', 'name'])->asArray()->all(), 'id', 'name'), [
                'label' => Module::t('import', 'Tag'),
                'hint' => Module::t('import', 'Tag which will be attached to the composite'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>




