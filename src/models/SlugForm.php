<?php

namespace blackcube\admin\models;

use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Seo;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Slug;
use yii\base\Model;

class SlugForm extends Model
{
    public $hasSlug;
    public $openedSlug = 0;

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

    public static function getFrequencies()
    {
        return array_combine(Sitemap::FREQUENCY, Sitemap::FREQUENCY);
    }

    public static function getPriorities()
    {
        return array_combine(Sitemap::PRIORITY, Sitemap::PRIORITY);
    }

    public function rules()
    {
        return [
            [['hasSlug'], 'filter', 'filter' => function($value) {
                return (boolean)$value;
            }],
            [['hasSlug'], 'boolean'],
        ];
    }

    public function setElement(ElementInterface $element)
    {
        $this->_element = $element;
        $this->_slug = $this->_element->getSlug()->one();
        if ($this->_slug === null) {
            $this->_slug = new Slug();
            $this->hasSlug = false;
        } else {
            $this->hasSlug = true;
        }
        $this->_sitemap = $this->_slug->getSitemap()->one();
        if ($this->_sitemap === null) {
            $this->_sitemap = new Sitemap(['priority' => 0.5, 'frequency' => 'daily']);
        }
        $this->_seo = $this->_slug->getSeo()->one();
        if ($this->_seo === null) {
            $this->_seo = new Seo();
        }
    }

    public function multiLoad($data)
    {
        $status = $this->_seo->load($data);
        $status = $status && $this->_sitemap->load($data);
        $status = $status && $this->_slug->load($data);
        $status = $status && $this->load($data);
        return $status;
    }

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

    public function getElement()
    {
        return $this->_element;
    }
    public function getSlug()
    {
        return $this->_slug;
    }
    public function getSitemap()
    {
        return $this->_sitemap;
    }

    public function getSeo()
    {
        return $this->_seo;
    }
}
