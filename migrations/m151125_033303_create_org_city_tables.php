<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151125_033303_create_org_city_tables extends BaseMigration
{
    public function up()
    {
//        return true;
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%city}}', [
            'city_id' => Schema::TYPE_PK,
            'city_key' => Schema::TYPE_STRING . '(16) Not Null Comment \'Код\'',
            'city_name' => Schema::TYPE_STRING . '(32) Not Null Comment \'Название\'',
            'city_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_city_key', '{{%city}}', 'city_key');
        $this->createIndex('idx_city_name', '{{%city}}', 'city_name');

        $this->createTable('{{%org}}', [
            'org_id' => Schema::TYPE_PK,
            'org_key' => Schema::TYPE_STRING . '(16) Not Null Comment \'Код\'',
            'org_name' => Schema::TYPE_STRING . '(32) Not Null Comment \'Название\'',
            'org_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_org_key', '{{%org}}', 'org_key');
        $this->createIndex('idx_org_name', '{{%org}}', 'org_name');

        $this->refreshCache();
    }

    public function down()
    {
//        return true;
        $this->dropTable('{{%city}}');
        $this->dropTable('{{%org}}');
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
