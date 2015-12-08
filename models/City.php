<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "{{%city}}".
 *
 * @property integer $city_id
 * @property string $city_key
 * @property string $city_name
 * @property string $city_created
 */
class City extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['city_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%city}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['city_key', 'city_name', ], 'required'],
            [['city_created'], 'safe'],
            [['city_key'], 'string', 'max' => 16],
            [['city_key'], 'match', 'pattern' => '|^[\\d]+$|'],
            [['city_name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'city_id' => Yii::t('app', 'City ID'),
            'city_key' => Yii::t('app', 'Код'),
            'city_name' => Yii::t('app', 'Название'),
            'city_created' => Yii::t('app', 'Создан'),
        ];
    }
}
