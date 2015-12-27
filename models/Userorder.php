<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%userorder}}".
 *
 * @property integer $ord_id
 * @property integer $ord_us_id
 * @property double $ord_summ
 * @property integer $ord_flag
 * @property string $ord_created
 */
class Userorder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userorder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ord_us_id', 'ord_created'], 'required'],
            [['ord_us_id', 'ord_flag'], 'integer'],
            [['ord_summ'], 'number'],
            [['ord_created'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ord_id' => 'Ord ID',
            'ord_us_id' => 'Клиент',
            'ord_summ' => 'Сумма',
            'ord_flag' => 'Состояние',
            'ord_created' => 'Создан',
        ];
    }
}
