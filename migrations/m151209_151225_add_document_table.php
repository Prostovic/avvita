<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151209_151225_add_document_table extends BaseMigration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%docdata}}', [
            'doc_id' => Schema::TYPE_PK,
            'doc_key' => Schema::TYPE_STRING . '(16) Not Null Comment \'Номер\'',
            'doc_date' => Schema::TYPE_DATETIME . ' Not Null Comment \'Дата\'',
            'doc_ordernum' => Schema::TYPE_STRING . '(32) Not Null Comment \'Номер заказа\'',
            'doc_fullordernum' => Schema::TYPE_STRING . '(32) Not Null Comment \'Полный номер заказа\'',
            'doc_org_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Организация\'',
            'doc_title' => Schema::TYPE_STRING . '(255) Not Null Comment \'Нименование\'',
            'doc_number' => Schema::TYPE_INTEGER . ' Not Null Comment \'Кол-во\'',
            'doc_summ' => Schema::TYPE_DOUBLE . ' Not Null Comment \'Сумма\'',
            'doc_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);

        $this->createIndex('idx_doc_key', '{{%docdata}}', 'doc_key');
        $this->createIndex('idx_doc_org_id', '{{%docdata}}', 'doc_org_id');
        $this->createIndex('idx_doc_ordernum', '{{%docdata}}', 'doc_ordernum');
        $this->createIndex('idx_doc_date', '{{%docdata}}', 'doc_date');

        $this->refreshCache();
    }

    public function down()
    {
        $this->dropTable('{{%docdata}}');
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
