<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%userdata}}".
 *
 * @property integer $ud_id
 * @property integer $ud_doc_id
 * @property integer $ud_us_id
 * @property string $ud_created
 */
class Userdata extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ud_doc_id', 'ud_us_id', 'ud_created'], 'required'],
            [['ud_doc_id', 'ud_us_id'], 'integer'],
            [['ud_created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ud_id' => 'Ud ID',
            'ud_doc_id' => 'Документ',
            'ud_us_id' => 'Пользователь',
            'ud_created' => 'Создан',
        ];
    }
}
