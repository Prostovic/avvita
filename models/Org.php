<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%org}}".
 *
 * @property integer $org_id
 * @property string $org_key
 * @property string $org_name
 * @property string $org_created
 */
class Org extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['org_created'],
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
        return '{{%org}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['org_key', 'org_name', ], 'required'],
            [['org_created'], 'safe'],
            [['org_key'], 'string', 'max' => 16],
            [['org_key'], 'match', 'pattern' => '|^[\\d]+$|'],
            [['org_name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'org_id' => Yii::t('app', 'Org ID'),
            'org_key' => Yii::t('app', 'Код'),
            'org_name' => Yii::t('app', 'Название'),
            'org_created' => Yii::t('app', 'Создан'),
        ];
    }

    public static function getCities() {
        return ArrayHelper::map(self::find()->orderBy('org_name')->all(), 'org_id', 'org_name');
    }

}
