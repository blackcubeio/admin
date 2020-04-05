<?php

namespace blackcube\admin\widgets;

use blackcube\core\interfaces\ElementInterface;
use yii\base\Widget;

class Publication extends Widget
{
    /**
     * @var ElementInterface
     */
    public $element;

    public function run()
    {
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

        return $this->render('publication', [
            'slugStatus' => $slugStatus,
            'sitemapStatus' => $sitemapStatus,
            'seoStatus' => $seoStatus,
        ]);
    }
}
