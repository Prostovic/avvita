<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m160109_084829_add_user_reset_key extends BaseMigration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'us_op_key', Schema::TYPE_STRING . ' Comment \'Ключ для действий\'');
        $this->createIndex('idx_us_op_key', '{{%user}}', 'us_op_key');
        $this->refreshCache();
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'us_op_key');
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
