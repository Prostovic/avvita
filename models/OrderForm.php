<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Docdata;
use app\models\Userdata;

/**
 * LoginForm is the model behind the login form.
 */
class OrderForm extends Model
{
    const DOCDATA_FIELD_NUM = 'doc_key';

    public $ordernum;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['ordernum'], 'required'],
            [['ordernum', ], 'string', 'min'=>3, 'max'=>16],
            [['ordernum'], 'testOrder'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ordernum' => 'Номер заказа',
        ];
    }

    /**
     * @inheritdoc
     */
    public function testOrder($attribute, $params)
    {
//        $nCou = Yii::$app
//            ->db
//            ->createCommand('Select COUNT(*) From ' . Docdata::tableName() . ' Where '.self::DOCDATA_FIELD_NUM.' = :ordernum', [':ordernum' => $this->{$attribute}])
//            ->queryScalar();
//        if( $nCou < 1 ) {
//            $this->addError($attribute, 'Заказ в системе не найден.');
//        }

        $nCou = Yii::$app
            ->db
            ->createCommand(
                'Select COUNT(*) From ' . Userdata::tableName() . ' Where ud_doc_key = :ordernum And ud_us_id = :uid',
                [':ordernum' => $this->{$attribute}, ':uid' => Yii::$app->user->getId()]
            )
            ->queryScalar();
        if( $nCou > 0 ) {
            $this->addError($attribute, 'Заказ уже есть в Вашем списке.');
        }
        else {
//            $nCou = Yii::$app
//                ->db
//                ->createCommand(
//                    'Select COUNT(*) From ' . Userdata::tableName() . ' Where ud_doc_key = :ordernum',
//                    [':ordernum' => $this->{$attribute}, ]
//                )
//                ->queryScalar();
//            if( $nCou > 0 ) {
//                $this->addError($attribute, 'Заказ уже закреплен за пользователем.');
//            }
        }

    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        $ob = new Userdata();
        $ob->ud_doc_key = $this->ordernum;
        $ob->ud_doc_id = 0;
        $ob->ud_us_id = Yii::$app->user->getId();
        if( !$ob->save() ) {
            Yii::info('Error save useddata: ' . print_r($ob->getErrors(), true));
            return false;
        }
        return true;
    }

}
