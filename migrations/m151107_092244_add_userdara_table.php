<?php

use yii\db\Schema;
use app\components\BaseMigration;
//use yii;

class m151107_092244_add_userdara_table extends BaseMigration // Migration
{
    public function up()
    {
//        print_r(Yii::$aliases);
//        print_r(posix_getuid());
//        print_r(posix_getpwuid(posix_getuid()));
//        return false;
        $tableOptionsMyISAM = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=MyISAM';
        $this->createTable('{{%user}}', [
            'us_id' => Schema::TYPE_PK,
            'us_group' => Schema::TYPE_STRING . '(16) Not Null Comment \'Группа\'',
            'us_active' => Schema::TYPE_SMALLINT . ' Default 1 Comment \'Активен\'',
            'us_fam' => Schema::TYPE_STRING . '(32) Not Null Comment \'Фамилия\'',
            'us_name' => Schema::TYPE_STRING . '(32) Not Null Comment \'Имя\'',
            'us_otch' => Schema::TYPE_STRING . '(32) Comment \'Отчество\'',
            'us_email' => Schema::TYPE_STRING . '(64) Not Null Comment \'Электронная почта\'',
            'us_phone' => Schema::TYPE_STRING . '(24) Comment \'Телефон\'',
            'us_adr_post' => Schema::TYPE_STRING . ' Comment \'Адрес доставки\'',
            'us_birth' => Schema::TYPE_DATE . ' Comment \'Дата рождения\'',
            'us_pass' => Schema::TYPE_STRING . ' Not Null Comment \'Пароль\'',
            'us_position' => Schema::TYPE_INTEGER . ' Comment \'Специализация\'',
            'us_city' => Schema::TYPE_STRING . ' Comment \'Город\'',
            'us_org' => Schema::TYPE_STRING . ' Comment \'Название организации\'',
            'us_city_id' => Schema::TYPE_STRING . '(16) Comment \'id города\'',
            'us_org_id' => Schema::TYPE_STRING . '(16) Comment \'id организации\'',
            'us_created' => Schema::TYPE_DATETIME . ' Not Null Comment \'Создан\'',
            'us_confirm' => Schema::TYPE_DATETIME . ' Default Null Comment \'Подтвержден\'',
            'us_activate' => Schema::TYPE_DATETIME . ' Default Null Comment \'Проверен\'',
            'us_getnews' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Инф. об акциях\'',
            'us_getstate' => Schema::TYPE_SMALLINT . ' Default 0 Comment \'Инф. о бонусах\'',
        ], $tableOptionsMyISAM);
        $this->createIndex('idx_us_email', '{{%user}}', 'us_email');
        $this->refreshCache();
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
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
