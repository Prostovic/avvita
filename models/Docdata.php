<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

use app\models\Org;

/**
 * This is the model class for table "{{%docdata}}".
 *
 * @property integer $doc_id
 * @property string $doc_key
 * @property string $doc_date
 * @property string $doc_ordernum
 * @property string $doc_fullordernum
 * @property integer $doc_org_id
 * @property string $doc_title
 * @property integer $doc_number
 * @property double $doc_summ
 * @property string $doc_created
 */
class Docdata extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['doc_created'],
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
        return '{{%docdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['doc_key', 'doc_ordernum', 'doc_fullordernum', 'doc_org_id', 'doc_title', 'doc_number', 'doc_summ', ], 'required'],
            [['doc_date', 'doc_created'], 'filter', 'filter' => function($val) { $newVal = trim($val); if( preg_match('|([\\d]{1,2})\.([\\d]{1,2})\.([\\d]{4})|', $newVal, $a) ) { $newVal = $a[3] . '-' . $a[2] . '-' . $a[1]; } return $newVal; }],
//            [['doc_date', 'doc_created'], 'safe'],
            [['doc_org_id', 'doc_number'], 'integer'],
            [['doc_summ'], 'number'],
            [['doc_key'], 'string', 'max' => 16],
            [['doc_ordernum', 'doc_fullordernum'], 'string', 'max' => 32],
            [['doc_title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'doc_id' => 'Doc ID',
            'doc_key' => 'Номер',
            'doc_date' => 'Дата',
            'doc_ordernum' => 'Номер заказа',
            'doc_fullordernum' => 'Полный номер заказа',
            'doc_org_id' => 'Организация',
            'doc_title' => 'Нименование',
            'doc_number' => 'Кол-во',
            'doc_summ' => 'Сумма',
            'doc_created' => 'Создан',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrg() {
        return $this->hasOne(Org::className(), ['org_key' => 'doc_org_id']);
    }
}
