<?php
/**
 * m000000_000000_administrators.php
 *
 * PHP version 8.2+
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
 */

namespace blackcube\admin\migrations;

use yii\db\Migration;

/**
 * Class m000000_000000_administrators
 *
 * @author Philippe Gaultier <pgaultier@gmail.com>
 * @copyright 2010-2025 Philippe Gaultier
 * @license https://www.blackcube.io/license
 * @link https://www.blackcube.io
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
