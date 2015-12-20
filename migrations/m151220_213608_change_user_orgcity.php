<?php

use yii\db\Schema;
use yii\db\Migration;
use app\components\BaseMigration;

class m151220_213608_change_user_orgcity extends BaseMigration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'us_city_id', Schema::TYPE_INTEGER . ' Comment \'id города\'');
        $this->alterColumn('{{%user}}', 'us_org_id', Schema::TYPE_INTEGER . ' Comment \'id организации\'');
        $this->refreshCache();
    }

    public function down()
    {
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
