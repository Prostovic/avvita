<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m160107_093828_add_order_message extends BaseMigration
{
    public function up()
    {
        $this->addColumn('{{%userorder}}', 'ord_message', Schema::TYPE_TEXT . ' Comment \'Сообщение\'');
        $this->refreshCache();
    }

    public function down()
    {
        $this->dropColumn('{{%userorder}}', 'ord_message');
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
