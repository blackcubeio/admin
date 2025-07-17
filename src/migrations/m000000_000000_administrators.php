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
class m000000_000000_administrators extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%administrators}}', [
            'id' => $this->bigPrimaryKey(),
            'email' => $this->string(190)->notNull()->unique(),
            'password' => $this->string(190),
            'active' => $this->boolean()->defaultValue(false)->notNull(),
            'authKey' => $this->string(190),
            'token' => $this->string(190),
            'tokenType' => $this->string(190),
            'dateCreate' => $this->dateTime()->notNull(),
            'dateUpdate' => $this->dateTime(),
        ]);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%administrators}}');
        return true;
    }
}
