<?php
/**
 * SlugForm.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Model;
use Yii;

/**
 * SlugForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */
class SlugForm extends Model
{
    /**
     * @var boolean
     */
    public $openedSlug;

    /**
     * @var boolean
     */
    public $hasSlug;

    /**
     * @var ElementInterface
     */
    private $_element;

    /**
     * @var Slug
     */
    private $_slug;
    /**
     * @var Sitemap
     */
    private $_sitemap;
    /**
     * @var Seo
     */
    private $_seo;

    /**
     * @return array list of available sitemap frequencies
     */
    public static function getFrequencies()
    {
        return array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
    }

    /**
     * @return array list of available sitemap frequencies
     */
    public static function getPriorities()
    {
        return array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['hasSlug'], 'filter', 'filter' => function($value) {
                return (boolean)$value;
            }],
            [['hasSlug'], 'boolean'],
        ];
    }

    /**
     * @param ElementInterface $element
     * @throws \yii\base\InvalidConfigException
     */
    public function setElement(ElementInterface $element)
    {
        $this->_element = $element;
        $this->_slug = $this->_element->getSlug()->one();
        if ($this->_slug === null) {
            $this->_slug = Yii::createObject(Slug::class);
            $this->hasSlug = false;
        } else {
            $this->hasSlug = true;
        }
        $this->_sitemap = $this->_slug->getSitemap()->one();
        if ($this->_sitemap === null) {
            $this->_sitemap = Yii::createObject([
                'class' => Sitemap::class,
                'priority' => 0.5,
                'frequency' => 'daily'
            ]);
        }
        $this->_seo = $this->_slug->getSeo()->one();
        if ($this->_seo === null) {
            $this->_seo = Yii::createObject(Seo::class);
        }
    }

    /**
     * Load submodels
     * @param $data original POST data
     * @return bool
     */
    public function multiLoad($data)
    {
        $status = $this->_seo->load($data);
        $status = $status && $this->_sitemap->load($data);
        $status = $status && $this->_slug->load($data);
        $status = $status && $this->load($data);
        return $status;
    }

    /**
     * Prevalidate submodels
     * @return bool
     */
    public function preValidate()
    {
        $status = true;
        if ($this->hasSlug) {
            $status = $status && $this->_slug->validate();

            $previousScenario = $this->_seo->getScenario();
            $this->_seo->setScenario(Seo::SCENARIO_PRE_VALIDATE);
            $status = $status && $this->_seo->validate();
            $this->_seo->setScenario($previousScenario);

            // TODO: except slugId
            $previousScenario = $this->_sitemap->getScenario();
            $this->_sitemap->setScenario(Sitemap::SCENARIO_PRE_VALIDATE);
            $status = $status && $this->_sitemap->validate();
            $this->_sitemap->setScenario($previousScenario);
        }
        $status = $status && parent::validate();
        return $status;
    }

    /**
     * {@inheritDoc}
     */
    public function validate($attributeNames = null, $clearErrors = true)
    {
        $status = true;
        if ($this->hasSlug) {
            $status = $status && $this->_slug->validate($attributeNames, $clearErrors);
            $status = $status && $this->_seo->validate($attributeNames, $clearErrors);
            $status = $status && $this->_sitemap->validate($attributeNames, $clearErrors);
        }
        $status = $status && parent::validate($attributeNames, $clearErrors);
        return $status;
    }

    /**
     * Save submodels
     * @return bool
     */
    public function save()
    {
        $status = true;
        if ($this->hasSlug) {
            $status = $status && $this->_slug->save();
            $this->_seo->slugId = $this->_slug->id;
            $status = $status && $this->_seo->save();
            $this->_sitemap->slugId = $this->_slug->id;
            $status = $status && $this->_sitemap->save();
        }
        return $status;
    }

    /**
     * @return ElementInterface
     */
    public function getElement()
    {
        return $this->_element;
    }

    /**
     * @return Slug
     */
    public function getSlug()
    {
        return $this->_slug;
    }

    /**
     * @return Sitemap
     */
    public function getSitemap()
    {
        return $this->_sitemap;
    }

    /**
     * @return Seo
     */
    public function getSeo()
    {
        return $this->_seo;
    }
}
