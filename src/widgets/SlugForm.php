<?php
/**
 * SlugForm.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */

namespace blackcube\admin\widgets;

use blackcube\core\interfaces\ElementInterface;
use blackcube\admin\models\SlugForm as SlugFormModel;
use yii\base\Widget;

/**
 * Widget SlugForm
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\widgets
 */
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

    /**
     * {@inheritDoc}
     */
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
