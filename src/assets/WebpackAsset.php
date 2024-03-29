<?php
/**
 * WebpackAsset.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\assets
 */

namespace blackcube\admin\assets;

use yii\caching\Cache;
use yii\caching\FileDependency;
use yii\di\Instance;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\AssetBundle;
use yii\web\View;
use Exception;
use Yii;

/**
 * Base webpack assets
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\assets
 * @since XXX
 */
class WebpackAsset extends AssetBundle
{

    /**
     * @var string name of webpack asset catalog, should be in synch with webpack.config.js
     */
    public $webpackAssetCatalog = 'assets-catalog.json';

    /**
     * string base cache key
     */
    const CACHE_KEY = 'webpack:bundles:';

    /**
     * @var \yii\caching\Cache cache
     */
    public $cache = 'cache';

    /**
     * @inheritdoc
     */
    public $cacheEnabled = false;

    /**
     * @inheritdoc
     */
    public $webpackPath = '@blackcube/admin/assets/webpack';

    /**
     * @inheritdoc
     */
    public $webpackDistDirectory = 'build';

    /**
     * @inheritdoc
     */
    public $webpackBundles = [
        'manifest',
        'vendors',
        'jsoneditor',
        'fontawesome',
        'chartist',
        'main',
        'app'
    ];

    /**
     * @var array list of bundles which are css only
     */
    public $cssOnly = [
        'main',
        'jsoneditor',
        'fontawesome',
        'chartist',
    ];

    /**
     * @var array list of bundles which are js only
     */
    public $jsOnly = [
        'manifest',
        'vendors',
        'app',
    ];

    public $js = [
    ];
    /**
     * @inheritdoc
     */
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
        'defer' => 'defer',
    ];

    /**
     * @inheritdoc
     */
    public static function register($view)
    {
        /* @var $view View */
        $bundle = parent::register($view);
        $wp = 'var webpackBaseUrl = \'' .$bundle->baseUrl.'/\';';
        $view->registerJs($wp, View::POS_HEAD);
        $ajaxUrl = 'var ajaxBaseUrl = \''.Url::to(['ajax/']).'\';';
        $view->registerJs($ajaxUrl, View::POS_HEAD);
        return $bundle;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->mergeWebpackBundles();
        parent::init();
    }

    /**
     * Merge webpack bundles with classic bundles and cache it if needed
     * @return void
     * @throws Exception
     * @since XXX
     */
    protected function mergeWebpackBundles()
    {
        try {
            if ((isset($this->webpackPath) === true) && (is_array($this->webpackBundles) === true)) {
                $cacheKey = self::CACHE_KEY . get_called_class();
                $this->sourcePath = $this->webpackPath . '/' . $this->webpackDistDirectory;
                $cache = $this->getCache();
                if (($cache === null) || ($cache->get($cacheKey) === false)) {
                    $assetsFileAlias = $this->webpackPath . '/' . $this->webpackAssetCatalog;
                    $bundles = file_get_contents(Yii::getAlias($assetsFileAlias));
                    $bundles = Json::decode($bundles);
                    if ($cache !== null) {
                        $cacheDependency = Yii::createObject([
                            'class' => FileDependency::class,
                            'fileName' => $assetsFileAlias,
                        ]);
                        $cache->set($cacheKey, $bundles, 0, $cacheDependency);
                    }
                } else {
                    $bundles = $cache->get($cacheKey);
                }
                foreach($this->webpackBundles as $bundle) {
                    if (isset($bundles[$bundle]['js']) === true && in_array($bundle, $this->cssOnly) === false) {
                        $this->js[] = $bundles[$bundle]['js'];
                    }
                    if (isset($bundles[$bundle]['css']) === true && in_array($bundle, $this->jsOnly) === false) {
                        $this->css[] = $bundles[$bundle]['css'];
                    }
                }
            }
        } catch(Exception $e) {
            Yii::error($e->getMessage(), 'sweelix\webpack');
            throw $e;
        }
    }

    /**
     * @return null|Cache
     * @throws \yii\base\InvalidConfigException
     * @since XXX
     */
    private function getCache()
    {
        return $this->cacheEnabled ? $this->get('cache') : null;
    }
}
