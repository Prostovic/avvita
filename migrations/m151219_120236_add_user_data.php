<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151219_120236_add_user_data extends BaseMigration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%userdata}}', [
            'ud_id' => Schema::TYPE_PK,
            'ud_doc_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Документ\'',
            'ud_us_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Пользователь\'',
            'ud_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);

        $this->createIndex('idx_ud_doc_id', '{{%userdata}}', 'ud_doc_id');
        $this->createIndex('idx_ud_us_id', '{{%userdata}}', 'ud_us_id');

        $this->refreshCache();

    }

    public function down()
    {
        $this->dropTable('{{%userdata}}');
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
