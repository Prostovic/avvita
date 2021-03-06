<?php

namespace app\models;

use Yii;
use app\models\Userorder;
use app\models\Good;

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
    public $orderredcount = 0;

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
            'orderredcount' => 'Заказано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder() {
        return $this->hasOne(
            Userorder::className(),
            ['ord_id' => 'ordit_ord_id']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGood() {
        return $this->hasOne(
            Good::className(),
            ['gd_id' => 'ordit_gd_id']
        );
    }
}
