<?php
/**
 * FaviconAsset.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\assets;

use yii\web\AssetBundle;

/**
 * favicon static assets
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 * @since XXX
 */
class FaviconAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@blackcube/admin/assets/favicon';

    /**
     * @inheritdoc
     */
    public $js = [
    ];

    /**
     * @inheritdoc
     */
    public $css = [
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
    ];

    public static function register($view)
    {
        $bundle = parent::register($view);
        $view->registerLinkTag([
            'rel' => 'shortcut icon',
            'type' => 'image/x-icon',
            'href' => $bundle->baseUrl.'/favicon.ico'
        ]);
        $view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'href' => $bundle->baseUrl.'/favicon.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'sizes' => '32x32',
            'href' => $bundle->baseUrl.'/favicon-32.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'sizes' => '64x64',
            'href' => $bundle->baseUrl.'/favicon-64.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'sizes' => '96x96',
            'href' => $bundle->baseUrl.'/favicon-96.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/png',
            'sizes' => '196x196',
            'href' => $bundle->baseUrl.'/favicon-196.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '152x152',
            'href' => $bundle->baseUrl.'/apple-touch-icon.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '60x60',
            'href' => $bundle->baseUrl.'/apple-touch-icon-60x60.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '76x76',
            'href' => $bundle->baseUrl.'/apple-touch-icon-76x76.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '114x114',
            'href' => $bundle->baseUrl.'/apple-touch-icon-114x114.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '120x120',
            'href' => $bundle->baseUrl.'/apple-touch-icon-120x120.png'
        ]);
        $view->registerLinkTag([
            'rel' => 'apple-touch-icon',
            'sizes' => '144x144',
            'href' => $bundle->baseUrl.'/apple-touch-icon-144x144.png'
        ]);
        $view->registerMetaTag([
            'name' => 'msapplication-TileImage',
            'content' => $bundle->baseUrl.'/favicon-144.png'
        ]);
        $view->registerMetaTag([
            'name' => 'msapplication-TileColor',
            'content' => '#000000'
        ]);
        return $bundle;
    }

}
