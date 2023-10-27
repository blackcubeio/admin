<?php
/**
 * Publication.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */

namespace blackcube\admin\widgets;

use blackcube\admin\Module;
use blackcube\core\Module as CoreModule;
use blackcube\core\helpers\QueryCache;
use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Slug;
use yii\base\Widget;

/**
 * Widget Publication
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
class Publication extends Widget
{
    /**
     * @var string
     */
    public $cacheId;

    /**
     * @var ElementInterface|Slug
     */
    public $element;

    public function init()
    {
        parent::init();
        if ($this->cacheId === null && Module::getInstance()->get('cache') !== null) {
            $className = get_class($this->element);
            $this->cacheId = Module::getInstance()->uniqueId.':widgets:publication:'. $className::getElementType().'-'.$this->element->id;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run()
    {
        $cache = Module::getInstance()->get('cache');
        $cache = null;
        $content = false;
        /* @var $cache \yii\caching\Cache */
        if ($cache !== null && $this->cacheId !== null) {
            $content = $cache->get($this->cacheId);
        }
        if ($content === false) {
            if ($this->element instanceof Slug) {
                $slugStatus = (($this->element !== null) && ($this->element->active)) ? 'active' : 'inactive';
                if ($slugStatus === 'inactive') {
                    $sitemapStatus = ($this->element->sitemap && $this->element->sitemap->active) ? 'deactivated':'inactive';
                } else {
                    $sitemapStatus = ($this->element->sitemap && $this->element->sitemap->active) ? 'active':'inactive';
                }
                if ($slugStatus === 'inactive') {
                    $seoStatus = ($this->element->seo && $this->element->seo->active) ? 'deactivated':'inactive';
                } else {
                    $seoStatus = ($this->element->seo && $this->element->seo->active) ? 'active':'inactive';
                }
            } else {
                $elementStatus = $this->element->active;
                if ($elementStatus) {
                    $slugStatus = (($this->element->slug !== null) && ($this->element->slug->active)) ? 'active' : 'inactive';
                    if ($slugStatus === 'inactive') {
                        $sitemapStatus = ($this->element->slug && $this->element->slug->sitemap && $this->element->slug->sitemap->active) ? 'deactivated':'inactive';
                    } else {
                        $sitemapStatus = ($this->element->slug && $this->element->slug->sitemap && $this->element->slug->sitemap->active) ? 'active':'inactive';
                    }
                    if ($slugStatus === 'inactive') {
                        $seoStatus = ($this->element->slug && $this->element->slug->seo && $this->element->slug->seo->active) ? 'deactivated':'inactive';
                    } else {
                        $seoStatus = ($this->element->slug && $this->element->slug->seo && $this->element->slug->seo->active) ? 'active':'inactive';
                    }
                } else {
                    $slugStatus = (($this->element->slug !== null) && ($this->element->slug->active)) ? 'deactivated' : 'inactive';
                    $sitemapStatus = ($this->element->slug && $this->element->slug->sitemap && $this->element->slug->sitemap->active) ? 'deactivated':'inactive';
                    $seoStatus = ($this->element->slug && $this->element->slug->seo && $this->element->slug->seo->active) ? 'deactivated':'inactive';
                }
            }
            $content = $this->render('publication', [
                'slugStatus' => $slugStatus,
                'sitemapStatus' => $sitemapStatus,
                'seoStatus' => $seoStatus,
            ]);
            if ($cache !== null && $this->cacheId !== null) {
                $cache->set($this->cacheId, $content, CoreModule::getInstance()->cacheDuration, QueryCache::getCmsDependencies());
            }
        }
        return $content;
    }
}
