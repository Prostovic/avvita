<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m160311_181044_add_good_group extends BaseMigration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%group}}', [
            'grp_id' => Schema::TYPE_PK,
            'grp_title' => Schema::TYPE_STRING . ' Comment \'Наименование\'',
            'grp_imagepath' => Schema::TYPE_STRING . ' Comment \'Изображение\'',
            'grp_description' => Schema::TYPE_TEXT . ' Comment \'Описание\'',
            'grp_active' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Показать\'',
            'grp_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создана\'',
        ], $tableOptionsMyISAM);
//        $this->createIndex('idx_ud_us_id', '{{%group}}', 'ud_us_id');

        $this->createTable('{{%goodgroup}}', [
            'gdgrp_id' => Schema::TYPE_PK,
            'gdgrp_gd_id' => Schema::TYPE_INTEGER . ' Comment \'Подарок\'',
            'gdgrp_grp_id' => Schema::TYPE_INTEGER . ' Comment \'Группа\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_gdgrp_gd_id', '{{%goodgroup}}', 'gdgrp_gd_id');
        $this->createIndex('idx_gdgrp_grp_id', '{{%goodgroup}}', 'gdgrp_grp_id');

        $this->refreshCache();

    }

    public function down()
    {
        $this->dropTable('{{%goodgroup}}');
        $this->dropTable('{{%group}}');
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
