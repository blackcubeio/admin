<?php
/**
 * HeroiconsController.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\commands;

use blackcube\admin\helpers\Html;
use blackcube\admin\Module;
use yii\console\Controller;
use yii\console\ExitCode;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * HeroiconsController Handler
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class HeroiconsController extends Controller
{

    private $heroiconsAlias = '@blackcube/admin/helpers/heroicons';
    private $heroiconsHelperAlias = '@blackcube/admin/helpers/Heroicons.php';
    /**
     * Generate Heroicon class with inlined SVGs
     * @return int
     * @throws \yii\base\InvalidConfigException
     */
    public function actionIndex()
    {
        $this->stdout(Module::t('console', 'Generate Heroicons helper'."\n"));
        $path = Yii::getAlias($this->heroiconsAlias);
        $files = $this->findSvg($path);
        $svgs = [];
        foreach ($files as $file) {
            $svg = $this->extractData($file);
            if($svg !== null) {
                $svgs = ArrayHelper::merge($svgs, $svg);
            }
        }
        $fileData = $this->prepareHelper($svgs);
        $target = Yii::getAlias($this->heroiconsHelperAlias);
        file_put_contents($target, $fileData);
        return ExitCode::OK;
    }

    private function prepareHelper($svgs)
    {
        $start = <<<'EOSTART'
<?php
/**
 * Heroicons.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\helpers;

use blackcube\core\interfaces\ElasticInterface;
use yii\base\InvalidArgumentException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\Json;

/**
 * Class Heroicons
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class Heroicons {

    private static $svg = [
        'outline' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'fill' => 'none',
            'viewBox' => '0 0 24 24',
            'stroke-width' => '1.5',
            'stroke' => 'currentColor',
            'aria-hidden' => 'true',
        ],
        'solid' => [
            'xmlns' => 'http://www.w3.org/2000/svg',
            'viewBox' => '0 0 24 24',
            'fill' => 'currentColor',
            'aria-hidden' => 'true',
        ]
    ];

    private static $paths = [
EOSTART;

        $lines = [];
        foreach($svgs as $key => $elements) {
            $lines[] = '        \'' . $key . '\' => [';
            foreach ($elements as $element) {
                $lines[] = '            \'' . $element .'\',';
            }
            $lines[] = '        ],';
        }
    $data = implode("\n", $lines);

    $end = <<<'EOEND'
    ];

    public static function svg($name, $options = []) {
        [$type, ] = explode('/', $name);
        $svg = '';
        if ($type === 'outline' || $type === 'solid') {
            $baseOptions = self::$svg[$type];
            $options = ArrayHelper::merge($baseOptions, $options);
            $path = self::$paths[$name]??null;
            if ($path !== null) {
                $path = is_array($path)?implode("\n", $path):$path;
                $svg = Html::tag('svg', $path, $options);
            }
        }
        return $svg;
    }
}
EOEND;
        return $start."\n".$data."\n".$end;
    }
    private function extractData($file)
    {
        $dom = new \DOMDocument();
        $dom->load($file);
        $realName = pathinfo($file, PATHINFO_FILENAME);
        if(strpos($file, 'outline') !== false) {
            $realName = 'outline/'.$realName;
        } elseif(strpos($file, 'solid') !== false) {
            $realName = 'solid/'.$realName;
        } else {
            return null;
        }
        $elements = null;
        $svgTags = $dom->getElementsByTagName('svg');
        foreach ($svgTags as $svgTag) {
            $childNodes = $svgTag->childNodes;
            $elements[$realName] = [];
            foreach ($childNodes as $childNode) {
                if ($childNode->hasAttributes()) {
                    $name = $childNode->nodeName;
                    $attributes = [];
                    foreach ($childNode->attributes as $key => $value) {
                        $attributes[$key] = $value->value;
                    }
                    $elements[$realName][] = self::tag($name, $attributes);
                }
            }
            if(empty($elements[$realName])) {
                $elements = null;
            }
        }
        return $elements;
    }

    private static function tag($name, $options = [])
    {
        return "<$name" . Html::renderTagAttributes($options) . '/>';
    }

    private function findSvg($directory)
    {
        $files = scandir($directory);
        $results = [];
        foreach ($files as $value) {
            // $this->stdout('Found - '.$value."\n");
            // $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            $path = $directory.DIRECTORY_SEPARATOR.$value;
            if (!is_dir($path) && pathinfo($value, PATHINFO_EXTENSION) === 'svg') {
                // $this->stdout('Found - '.$path."\n");
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                $additionalResults = $this->findSvg($path);
                $results = ArrayHelper::merge($results, $additionalResults);
            }
        }

        return $results;
    }
}
