<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%docdata}}".
 *
 * @property integer $doc_id
 * @property string $doc_key
 * @property string $dac_date
 * @property string $doc_ordernum
 * @property integer $doc_org_id
 * @property string $doc_title
 * @property integer $doc_number
 * @property double $doc_summ
 * @property string $doc_created
 */
class Docdata extends \yii\db\ActiveRecord
{
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
            [['doc_key', 'dac_date', 'doc_ordernum', 'doc_org_id', 'doc_title', 'doc_number', 'doc_summ', 'doc_created'], 'required'],
            [['dac_date', 'doc_created'], 'safe'],
            [['doc_org_id', 'doc_number'], 'integer'],
            [['doc_summ'], 'number'],
            [['doc_key'], 'string', 'max' => 16],
            [['doc_ordernum'], 'string', 'max' => 32],
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
            'dac_date' => 'Дата',
            'doc_ordernum' => 'Заказ',
            'doc_org_id' => 'Организация',
            'doc_title' => 'Нименование',
            'doc_number' => 'Кол-во',
            'doc_summ' => 'Сумма',
            'doc_created' => 'Создан',
        ];
    }
}
