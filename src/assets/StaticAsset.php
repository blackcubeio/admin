<?php
/**
 * StaticAsset.php
 *
 * PHP version 7.1+
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2018 Ibitux
 * @license https://www.ibitux.com/license license
 * @version XXX
 * @link https://www.ibitux.com
 * @package blackcube\admin\assets
 */

namespace blackcube\admin\assets;

use yii\caching\Cache;
use yii\caching\FileDependency;
use yii\di\Instance;
use yii\helpers\Json;
use yii\web\AssetBundle;
use yii\web\View;
use Exception;
use Yii;

/**
 * Base static assets
 *
 * @author Philippe Gaultier <pgaultier@ibitux.com>
 * @copyright 2010-2018 Ibitux
 * @license https://www.ibitux.com/license license
 * @version XXX
 * @link https://www.ibitux.com
 * @package blackcube\admin\assets
 * @since XXX
 */
class StaticAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@blackcube/admin/assets/static';

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

    /**
     * @inheritdoc
     */
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

}
