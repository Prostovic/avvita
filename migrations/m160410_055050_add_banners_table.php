<?php

use yii\db\Schema;
use app\components\BaseMigration;

class m160410_055050_add_banners_table extends BaseMigration
{
    public function up()
    {
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%banner}}', [
            'bnr_id' => Schema::TYPE_PK,
            'bnr_active' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Показать\'',
            'bnr_imagepath' => Schema::TYPE_STRING . ' Comment \'Изображение\'',
            'bnr_group' => Schema::TYPE_STRING . ' Comment \'Группа\'',
            'bnr_title' => Schema::TYPE_STRING . ' Comment \'Название\'',
            'bnr_description' => Schema::TYPE_TEXT . ' Comment \'Описание\'',
            'bnr_created' => Schema::TYPE_DATETIME . ' Comment \'Создана\'',
            'bnr_order' => Schema::TYPE_SMALLINT . ' Comment \'Порядок\'',
        ], $tableOptionsMyISAM);
//        $this->createIndex('idx_ud_us_id', '{{%group}}', 'ud_us_id');

        $this->refreshCache();

        $sDir = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'www/images/rotate';
        if( !is_dir($sDir) && !@mkdir($sDir) ) {
            echo str_repeat('*', 30) ."\n\nYou need to make dir {$sDir}\n\n" . str_repeat('*', 30) . "\n\n";
        }
        else {
            echo "\nDir exists {$sDir}\n";
            chmod($sDir, 0777);
        }

    }

    public function down()
    {
        $this->dropTable('{{%banner}}');
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
