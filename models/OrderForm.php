<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class OrderForm extends Model
{
    public $ordernum;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['ordernum'], 'required'],
            [['ordernum', ], 'string', 'min'=>3, 'max'=>16],
            // rememberMe must be a boolean value
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
        $this->addError($attribute, 'Заказ в системе не найден.');
    }

    /**
     * @inheritdoc
     */
    public function save()
    {
        return true;
    }

}
