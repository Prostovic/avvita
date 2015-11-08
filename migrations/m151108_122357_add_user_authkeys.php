<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151108_122357_add_user_authkeys extends BaseMigration // Migration
{
    public function up()
    {
        $this->addColumn(
            '{{%user}}',
            'us_key',
            Schema::TYPE_STRING . ' Comment \'API key\''
        );

        $this->addColumn(
            '{{%user}}',
            'us_confirmkey',
            Schema::TYPE_STRING . ' Comment \'Confirm key\''
        );

        $this->createIndex('idx_us_key', '{{%user}}', 'us_key');
        $this->createIndex('idx_us_confirmkey', '{{%user}}', 'us_confirmkey');
        $this->refreshCache();
    }

    public function down()
    {
        $this->dropColumn(
            '{{%user}}',
            'us_key'
        );

        $this->dropColumn(
            '{{%user}}',
            'us_confirmkey'
        );

        $this->dropIndex('idx_us_key', '{{%user}}');
        $this->dropIndex('idx_us_confirmkey', '{{%user}}');

        $this->refreshCache();
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
