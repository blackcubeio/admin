<?php
/**
 * m000000_000000_administrators.php
 *
 * PHP version 7.2+
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\migrations
 */

namespace blackcube\admin\migrations;

use yii\db\Expression;
use yii\db\Migration;

/**
 * Class m000000_000000_administrators
 *
 * @author Philippe Gaultier <pgaultier@redcat.io>
 * @copyright 2010-2020 Redcat
 * @license https://www.redcat.io/license license
 * @version XXX
 * @link https://www.redcat.io
 * @package blackcube\admin\migrations
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
