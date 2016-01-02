<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use app\models\Orderitem;

/**
 * This is the model class for table "{{%good}}".
 *
 * @property integer $gd_id
 * @property string $gd_title
 * @property string $gd_imagepath
 * @property string $gd_description
 * @property double $gd_price
 * @property integer $gd_number
 * @property integer $gd_active
 * @property string $gd_created
 */
class Good extends \yii\db\ActiveRecord
{
    public $orderredcount = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['gd_created'],
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
        return '{{%good}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gd_title', 'gd_price', ], 'required'],
            [['gd_description'], 'string'],
            [['gd_price'], 'number'],
            [['gd_number', 'gd_active'], 'integer'],
            [['gd_created'], 'safe'],
            [['gd_title', 'gd_imagepath'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gd_id' => 'ID',
            'gd_title' => 'Наименование',
            'gd_imagepath' => 'Изображение',
            'gd_description' => 'Описание',
            'gd_price' => 'Стоимость',
            'gd_number' => 'Кол-во',
            'gd_active' => 'Показать',
            'gd_created' => 'Создан',
            'items' => 'В заказах',
            'orderredcount' => 'Заказано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems() {
        return $this->hasMany(
            Orderitem::className(),
            [
                'ordit_gd_id' => 'gd_id'
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdered() {
        return $this
            ->getItems()
            ->select('SUM() As orderredcount')
            ->groupBy(['ordit_gd_id'])
            ->scalar();
    }
}
