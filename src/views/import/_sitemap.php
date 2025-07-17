<?php
/**
 * _sitemap.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $sitemap array
 * @var $frequencies array
 * @var $priorities array
 * @var $this \yii\web\View
 */

use blackcube\admin\Module;
use blackcube\admin\helpers\Html;
use blackcube\core\interfaces\PluginsHandlerInterface;
use blackcube\admin\interfaces\PluginManagerAdminHookInterface;
use blackcube\core\models\Parameter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use blackcube\admin\helpers\Heroicons;
use blackcube\admin\helpers\BlackcubeHtml;
use blackcube\admin\helpers\Aurelia;
use blackcube\core\models\Tag;
?>

<?php if (isset($sitemap) === true &&is_array($sitemap)): ?>
    <div class="element-form-bloc-stacked">
        <?php echo BlackcubeHtml::checkbox('sitemapActive', $sitemap['active'] , [
            'hint' => Module::t('import', 'Sitemap status'),
            'label' => Module::t('import', 'Sitemap active'),
            'disabled' => 'disabled'
        ]); ?>
    </div>
    <div class="element-form-bloc-grid-12">
        <div class="element-form-bloc-cols-6">
            <?php echo BlackcubeHtml::dropDownList('sitemapFrequency', $sitemap['frequency'], $frequencies, [
                'prompt' => Module::t('import', 'Frequency'),
                'label' => Module::t('import', 'Frequency'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
        <div class="element-form-bloc-cols-6">
            <?php echo BlackcubeHtml::dropDownList('sitemapPriority', $sitemap['priority'], $priorities, [
                'prompt' => Module::t('import', 'Priority'),
                'label' => Module::t('import', 'Priority'),
                'disabled' => 'disabled'
            ]); ?>
        </div>
    </div>
<?php endif; ?>