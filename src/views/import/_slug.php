<?php
/**
 * _slug.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 *
 * @var $slug array
 * @var $typesQuery \yii\db\ActiveQuery
 * @var $languagesQuery \yii\db\ActiveQuery
 * @var $nodesQuery \yii\db\ActiveQuery
 * @var $tagsQuery \yii\db\ActiveQuery
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

            <?php if (isset($slug) === true && is_array($slug)): ?>
            <div class="element-form-bloc-stacked">
                <?php echo BlackcubeHtml::checkbox('slugActive', $slug['active'] , [
                    'hint' => Module::t('import', 'Slug status'),
                    'label' => Module::t('import', 'Slug active'),
                    'disabled' => 'disabled'
                ]); ?>
            </div>
            <div class="element-form-bloc-grid-12">
                <div class="element-form-bloc-cols-3">
                    <?php echo BlackcubeHtml::dropDownList('slugHost', $slug['host'], ArrayHelper::map(Parameter::getAllowedHosts(), 'id', 'value'), [
                            'disabled' => 'disabled',
                        'label' => Module::t('import', 'Host'),
                    ]); ?>
                </div>
                <div class="element-form-bloc-cols-9">
                    <?php echo BlackcubeHtml::input('text', 'slugPath', $slug['path'], [
                        'label' => Module::t('import', 'Path'),
                        'disabled' => 'disabled'
                    ]); ?>
                </div>
            </div>
                <?php if (isset($slug['sitemap']) === true): ?>
                    <?php echo $this->render('_sitemap', [
                        'sitemap' => $slug['sitemap'],
                        'priorities' => $priorities,
                        'frequencies' => $frequencies,
                    ]); ?>
                <?php endif; ?>
                <?php if (isset($slug['seo']) === true): ?>
                    <?php echo $this->render('_seo', [
                        'seo' => $slug['seo'],
                    ]); ?>
                <?php endif; ?>
            <?php endif; ?>

