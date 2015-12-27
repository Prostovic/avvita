<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%goodimg}}".
 *
 * @property integer $gi_id
 * @property integer $gi_gd_id
 * @property string $gi_path
 * @property string $gi_title
 * @property string $gi_created
 */
class Goodimg extends \yii\db\ActiveRecord
{
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
            [['gi_gd_id', 'gi_path', 'gi_created'], 'required'],
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
