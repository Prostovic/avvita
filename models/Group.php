<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $grp_id
 * @property string $grp_title
 * @property string $grp_imagepath
 * @property string $grp_description
 * @property integer $grp_active
 * @property string $grp_created
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grp_description'], 'string'],
            [['grp_active'], 'integer'],
            [['grp_created'], 'required'],
            [['grp_created'], 'safe'],
            [['grp_title', 'grp_imagepath'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grp_id' => 'Grp ID',
            'grp_title' => 'Наименование',
            'grp_imagepath' => 'Изображение',
            'grp_description' => 'Описание',
            'grp_active' => 'Показать',
            'grp_created' => 'Создана',
        ];
    }
}
