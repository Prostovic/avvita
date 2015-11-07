<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $us_id
 * @property integer $us_active
 * @property string $us_fam
 * @property string $us_name
 * @property string $us_otch
 * @property string $us_email
 * @property string $us_phone
 * @property string $us_adr_post
 * @property string $us_birth
 * @property string $us_pass
 * @property integer $us_position
 * @property string $us_city
 * @property string $us_org
 * @property string $us_city_id
 * @property string $us_org_id
 * @property string $us_created
 * @property string $us_confirm
 * @property string $us_activate
 * @property string $us_group
 * @property integer $us_getnews
 * @property integer $us_getstate
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['us_active', 'us_position', 'us_getnews', 'us_getstate'], 'integer'],
            [['us_fam', 'us_name', 'us_otch', 'us_email', 'us_adr_post', 'us_birth', 'us_pass', 'us_position', 'us_city', 'us_org', 'us_created'], 'required'],
            [['us_birth', 'us_created', 'us_confirm', 'us_activate'], 'safe'],
            [['us_fam', 'us_name', 'us_otch'], 'string', 'max' => 32],
            [['us_email'], 'string', 'max' => 64],
            [['us_phone'], 'string', 'max' => 24],
            [['us_adr_post', 'us_pass', 'us_city', 'us_org'], 'string', 'max' => 255],
            [['us_city_id', 'us_org_id', 'us_group'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'us_id' => 'Us ID',
            'us_active' => 'Активен',
            'us_fam' => 'Фамилия',
            'us_name' => 'Имя',
            'us_otch' => 'Отчество',
            'us_email' => 'Электронная почта',
            'us_phone' => 'Телефон',
            'us_adr_post' => 'Адрес доставки',
            'us_birth' => 'Дата рождения',
            'us_pass' => 'Пароль',
            'us_position' => 'Специализация',
            'us_city' => 'Город',
            'us_org' => 'Название организации',
            'us_city_id' => 'id города',
            'us_org_id' => 'id организации',
            'us_created' => 'Создан',
            'us_confirm' => 'Подтвержден',
            'us_activate' => 'Проверен',
            'us_getnews' => 'Инф. об акциях',
            'us_getstate' => 'Инф. о бонусах',
            'us_group' => 'Группа',
        ];
    }

    public function scenarios() {
        return [
            'backCreateUser' => [],
            'register' => [
                'us_fam',
                'us_name',
                'us_otch',
                'us_email',
                'us_phone',
                'us_adr_post',
                'us_birth',
                'us_pass',
                'us_position',
                'us_city',
                'us_org',
                'us_getnews',
                'us_getstate',
            ],
        ];
    }
}
