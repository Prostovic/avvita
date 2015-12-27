<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orderitem}}".
 *
 * @property integer $ordit_id
 * @property integer $ordit_ord_id
 * @property integer $ordit_gd_id
 * @property integer $ordit_count
 */
class Orderitem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orderitem}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ordit_ord_id', 'ordit_gd_id'], 'required'],
            [['ordit_ord_id', 'ordit_gd_id', 'ordit_count'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ordit_id' => 'Ordit ID',
            'ordit_ord_id' => 'Заказ',
            'ordit_gd_id' => 'Товар',
            'ordit_count' => 'Кол-во',
        ];
    }
}
