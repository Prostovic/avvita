<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class RepeatemailForm extends Model
{
    public $email;
    public $_user = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // email is required
            [['email'], 'required'],
            [['email', ], 'email'],
            [['email'], 'testMail'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Email',
        ];
    }

    /**
     * This method is for send repeat confirm email.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function testMail($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = User::find()
            ->where([
                'and',
                ['us_email' => $this->$attribute],
                ['<>', 'us_group', User::GROUP_DELETED],
                ['<>', 'us_confirmkey', '']
            ])
            ->one();

            if( $user ) {
                $this->_user = $user;
            }
            else {
                $this->addError($attribute, 'Не найден требуемый неподтвержденный email');
            }
        }
    }

    /**
     * @return null|app\models\User
     */
    public function getUser() {
        return $this->_user;
    }

}
