<?php
/**
 * m000000_000000_administrators.php
 *
 * PHP version 7.4+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\migrations
 */

namespace blackcube\admin\migrations;

use yii\db\Migration;

/**
 * Class m000000_000000_administrators
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2022 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\migrations
 */
class m000000_000001_administrators extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%administrators}}', 'firstname', $this->string(190)->notNull().' AFTER id');
        $this->addColumn('{{%administrators}}', 'lastname', $this->string(190)->notNull().' AFTER firstname');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%administrators}}', 'firstname');
        $this->dropColumn('{{%administrators}}', 'lastname');

        return true;
    }
}
