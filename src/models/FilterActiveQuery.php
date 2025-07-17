<?php
/**
 * FilterActiveQuery.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\models;

use blackcube\core\components\PreviewManager;
use yii\db\ActiveQuery;
use Yii;

/**
 * Class FilterActiveQuery
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */
class FilterActiveQuery extends ActiveQuery
{
    /**
     * @var PreviewManager
     */
    private $previewManager;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        parent::init();
        $this->previewManager = Yii::createObject(PreviewManager::class);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function active()
    {
        if ($this->previewManager->check() === false) {
            $this->andWhere([
                '[[active]]' => true,
            ]);
        }
        return $this;
    }
}
