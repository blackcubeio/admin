<?php

namespace blackcube\admin\widgets;

use blackcube\core\interfaces\ElementInterface;
use blackcube\core\models\Sitemap;
use blackcube\core\models\Seo;
use blackcube\core\models\Slug;
use blackcube\admin\models\SlugForm as SlugFormModel;
use yii\base\Widget;
use Yii;

class SlugForm extends Widget
{
    /**
     * @var ElementInterface
     */
    public $element;

    /**
     * @var SlugFormModel
     */
    public $slugForm;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('slug-form', [
            'slugForm' => $this->slugForm,
            'slug' => $this->slugForm->getSlug(),
            'sitemap' => $this->slugForm->getSitemap(),
            'seo' => $this->slugForm->getSeo(),
        ]);
    }

}
