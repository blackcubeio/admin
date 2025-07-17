<?php
/**
 * SearchForm.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\models;

use blackcube\admin\Module;
use yii\base\Model;

/**
 * SearchForm Model
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
