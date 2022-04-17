<?php
/**
 * FilterActiveQuery.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */

namespace blackcube\admin\models;

use blackcube\core\components\PreviewManager;
use yii\db\ActiveQuery;
use Yii;

/**
 * Class FilterActiveQuery
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
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
