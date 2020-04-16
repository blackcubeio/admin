<?php
/**
 * FilterActiveQuery.php
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

use yii\db\ActiveQuery;
use Yii;

/**
 * Class FilterActiveQuery
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\models
 */
class FilterActiveQuery extends ActiveQuery
{

    /**
     * @return \yii\db\ActiveQuery
     */
    public function active() {
        $this->andWhere([
            '[[active]]' => true,
        ]);
        return $this;
    }
}
