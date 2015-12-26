<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * LoginForm is the model behind the login form.
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            [['username', ], 'email'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Email',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить',
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неправильное имя пользователя или пароль.'); //  . Yii::$app->security->generatePasswordHash($this->password)
            }
            else {
                if( $user->us_group == User::GROUP_NEWREGISTER ) {
                    $this->addError($attribute, 'Вы не прошли проверку электрноой почты. Пройдите по ссылке в письме на Ваш адрес.');
                }
                if( $user->us_group == User::GROUP_CONFIRMED ) {
                    $this->addError($attribute, 'До проверки администраторм Вы не можете пользоваться сайтом.');
                }
                if( $user->us_group == User::GROUP_BLOCKED ) {
                    $this->addError($attribute, 'Вы не можете пользоваться данным сайтом.');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $am = Yii::$app->authManager;
            $oUser = $this->getUser();
            $am->revokeAll($oUser->us_id);
            $am->assign($am->getRole($oUser->us_group), $oUser->us_id);
            $am->getPermission($oUser->us_group);
            return Yii::$app->user->login($oUser, $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
