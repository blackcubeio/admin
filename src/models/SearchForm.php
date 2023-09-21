<?php
/**
 * SearchForm.php
 *
 * PHP version 8.0+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use blackcube\admin\Module;
use yii\base\Model;

/**
 * SearchForm Model
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */
class SearchForm extends Model
{

    /**
     * @var string
     */
    public $search;

    /**
     * @var boolean
     */
    public $composites;

    /**
     * @var boolean
     */
    public $nodes;

    /**
     * @var boolean
     */
    public $categories;

    /**
     * @var boolean
     */
    public $tags;

    /**
     * @var boolean
     */
    public $slugs;

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['composites', 'nodes', 'categories', 'tags', 'slugs'], 'default', 'value' => true],
            [['composites', 'nodes', 'categories', 'tags', 'slugs'], 'filter', 'filter' => function($value) {
                return (boolean)$value;
            }],
            [['search'], 'required'],
            [['search'], 'string'],
            [['composites', 'nodes', 'categories', 'tags', 'slugs'], 'boolean'],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function attributeLabels()
    {
        return [
            'composites' => Module::t('models', 'Composites'),
            'nodes' => Module::t('models', 'Nodes'),
            'categories' => Module::t('models', 'Categories'),
            'tags' => Module::t('models', 'Tags'),
            'slugs' => Module::t('models', 'Slugs'),
            'search' => Module::t('models', 'Search'),
        ];
    }
}
