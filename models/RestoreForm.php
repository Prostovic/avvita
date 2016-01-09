<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;
use app\components\Notificator;

/**
 * LoginForm is the model behind the login form.
 */
class RestoreForm extends Model
{
    public $email;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['email', ], 'required'],
            [['email', ], 'email'],
            [['email', ], 'validateUser'],
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
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateUser($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if( !$user ) {
                $this->addError($attribute, 'Неправильный email пользователя.');
            }
        }
    }

    /**
     *
     */
    public function createResetData()
    {
        $user = $this->getUser();
        if( !$user ) {
            return false;
        }

        $user->us_op_key = Yii::$app->security->generateRandomString() . time();

        if( !$user->save() ) {
            return false;
        }

        $ob = new Notificator([$user], $user, 'restore_pass_mail');
        $ob->notifyMail('Восстановление пароля на сайте ' . Yii::$app->name);

        return true;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }
}
