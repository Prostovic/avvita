<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151226_165629_change_user_data extends BaseMigration
{
    public function up()
    {
        $this->addColumn('{{%userdata}}', 'ud_doc_key', Schema::TYPE_STRING . ' Comment \'Номер заказа\'');
        $this->createIndex('idx_ud_doc_key', '{{%userdata}}', 'ud_doc_key');
        $this->refreshCache();

    }

    public function down()
    {
        $this->dropColumn('{{%userdata}}', 'ud_doc_key');
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
