<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%goodimg}}".
 *
 * @property integer $gi_id
 * @property integer $gi_gd_id
 * @property string $gi_path
 * @property string $gi_title
 * @property string $gi_created
 */
class Goodimg extends ActiveRecord
{
    /**
     * @return array
     */
    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['gi_created'],
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
        return '{{%goodimg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gi_gd_id', 'gi_path', ], 'required'],
            [['gi_gd_id'], 'integer'],
            [['gi_created'], 'safe'],
            [['gi_path', 'gi_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gi_id' => 'Gi ID',
            'gi_gd_id' => 'Товар',
            'gi_path' => 'Путь',
            'gi_title' => 'Описание',
            'gi_created' => 'Создан',
        ];
    }
}
