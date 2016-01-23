<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m151227_153402_add_good_table extends BaseMigration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%good}}', [
            'gd_id' => Schema::TYPE_PK,
            'gd_title' => Schema::TYPE_STRING . ' Not Null Comment \'Наименование\'',
            'gd_imagepath' => Schema::TYPE_STRING . ' Comment \'Изображение\'',
            'gd_description' => Schema::TYPE_TEXT . ' Comment \'Описание\'',
            'gd_price' => Schema::TYPE_FLOAT . ' Not Null Comment \'Стоимость\'',
            'gd_number' => Schema::TYPE_INTEGER . ' Default 0 Comment \'Кол-во\'',
            'gd_active' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Показать\'',
            'gd_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);
//        $this->createIndex('idx_ud_us_id', '{{%userdata}}', 'ud_us_id');

        $this->createTable('{{%goodimg}}', [
            'gi_id' => Schema::TYPE_PK,
            'gi_gd_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Товар\'',
            'gi_path' => Schema::TYPE_STRING . ' Not Null Comment \'Путь\'',
            'gi_title' => Schema::TYPE_STRING . ' Comment \'Описание\'',
            'gi_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_gi_gd_id', '{{%goodimg}}', 'gi_gd_id');

        $this->createTable('{{%userorder}}', [
            'ord_id' => Schema::TYPE_PK,
            'ord_us_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Клиент\'',
            'ord_summ' => Schema::TYPE_FLOAT . ' Not Null Default 0 Comment \'Сумма\'',
            'ord_flag' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Состояние\'',
            'ord_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_ord_us_id', '{{%userorder}}', 'ord_us_id');

        $this->createTable('{{%orderitem}}', [
            'ordit_id' => Schema::TYPE_PK,
            'ordit_ord_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Заказ\'',
            'ordit_gd_id' => Schema::TYPE_INTEGER . ' Not Null Comment \'Товар\'',
            'ordit_count' => Schema::TYPE_INTEGER . ' Not Null Default 0 Comment \'Кол-во\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_ordit_ord_id', '{{%orderitem}}', 'ordit_ord_id');
        $this->createIndex('idx_ordit_gd_id', '{{%orderitem}}', 'ordit_gd_id');

        $this->refreshCache();

//        $sDir = Yii::getAlias('@webroot/images/gd');
    }

    public function down()
    {
        $this->dropTable('{{%good}}');
        $this->dropTable('{{%goodimg}}');
        $this->dropTable('{{%userorder}}');
        $this->dropTable('{{%orderitem}}');
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
