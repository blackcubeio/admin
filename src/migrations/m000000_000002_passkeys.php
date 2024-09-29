<?php
/**
 * m000000_000000_administrators.php
 *
 * PHP version 8.0+
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
class m000000_000002_passkeys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%passkeys}}', [
            'id' => $this->string()->notNull(),
            'name' => $this->string(),
            'administratorId' => $this->bigInteger()->notNull(),
            'type' => $this->string()->notNull(),
            'attestationType' => $this->string(),
            'aaguid' => $this->string(),
            'credentialPublicKey' => $this->text(),
            'userHandle' => $this->string(),
            'counter' => $this->integer(),
            'jsonData' => $this->text(),
            'dateCreate' => $this->dateTime()->notNull(),
            'dateUpdate' => $this->dateTime()->notNull(),
            'PRIMARY KEY ([[id]])',
        ]);
        $this->addForeignKey('passkeys_administratorId_administrators_id', '{{%passkeys}}', 'administratorId', '{{%administrators}}', 'id', 'CASCADE', 'CASCADE');
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('passkeys_administratorId_administrators_id', '{{%passkeys}}');
        $this->dropTable('{{%passkeys}}');

        return true;
    }
}
