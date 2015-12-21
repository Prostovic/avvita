<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;

use app\components\ActionBehavior;
use app\components\Notificator;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $us_id
 * @property integer $us_active
 * @property string $us_fam
 * @property string $us_name
 * @property string $us_otch
 * @property string $us_email
 * @property string $us_phone
 * @property string $us_adr_post
 * @property string $us_birth
 * @property string $us_pass
 * @property integer $us_position
 * @property string $us_city
 * @property string $us_org
 * @property string $us_city_id
 * @property string $us_org_id
 * @property string $us_created
 * @property string $us_confirm
 * @property string $us_activate
 * @property string $us_group
 * @property string $us_confirmkey
 * @property string $us_key
 * @property integer $us_getnews
 * @property integer $us_getstate
 */
class User extends ActiveRecord implements IdentityInterface
{
    const GROUP_NEWREGISTER = 'newuser';
    const GROUP_CONFIRMED = 'confitmed';
    const GROUP_CLIENT = 'client';
    const GROUP_BLOCKED = 'blocked';
    const GROUP_OPERATOR = 'operator';
    const GROUP_ADMIN = 'admin';

    public $isAgree;
    public $password = '';


    public function behaviors() {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['us_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['us_activate'],
                ],
                'value' => function ($event) {
                    /** @var  $model User */
                    $model = $event->sender;
                    if( ($model->us_group == User::GROUP_CLIENT) && ($model->us_activate === null) ) {
                        $oRet = new Expression('NOW()');
                        $oNotify = new Notificator([$model], $model, 'activate_mail');
                        $oNotify->notifyMail('Вы проверены на портале "' . Yii::$app->name . '"');
                    }
                    else {
                        $oRet = $model->us_activate;
                    }
                    return $oRet;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'password',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'password',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    if( !empty($model->password) ) {
                        $model->setPassword($model->password);
                    }
                    return $model->password;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'us_key',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    $model->generateAuthKey();
                    return $model->us_key;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'us_birth',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'us_birth',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    if( preg_match('|^([\\d]+)\\.([\\d]+)\\.([\\d]+)$|', $model->us_birth, $a) ) {
                        return $a[3] . '-' . $a[2] . '-' . $a[1];
                    }
                    return $model->us_birth;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'us_confirmkey',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    return Yii::$app->security->generateRandomString() . '_' . time();
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'us_group',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    return ( $model->scenario == 'register' ) ? User::GROUP_NEWREGISTER : '';
                },
            ],
            [
                'class' => ActionBehavior::className(),
                'allevents' => [ActiveRecord::EVENT_AFTER_INSERT],
                'action' => function($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    if( $model->scenario == 'register' ) {
                        $oNotify = new Notificator([$model], $model, 'confirm_mail');
                        $oNotify->notifyMail('Подтвердите регистрацию на портале "' . Yii::$app->name . '"');
                    }
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['us_fam', 'us_name', 'us_email', 'us_adr_post', 'us_birth', 'us_position', 'us_city', 'us_org', 'us_getnews', 'us_getstate', 'us_city_id', 'us_org_id', ], 'required'],
            [['us_fam', 'us_name', 'us_otch', 'us_city', ], 'app\components\CapitalizeFilter'],
            [['isAgree', ], 'required', 'on' => ['register']],
            [['isAgree', ], 'compare', 'compareValue' => 1, 'message' => 'Необходимо отметить {attribute}', 'on' => ['register']],
            [['password', ], 'required', 'on'=>['register']],
            [['us_active', 'us_position', 'us_getnews', 'us_getstate', 'us_city_id', 'us_org_id', ], 'integer'],
            [['us_birth', 'us_created', 'us_confirm', 'us_activate'], 'safe'],
            [['us_fam', 'us_name', 'us_otch'], 'string', 'max' => 32],
            [['password'], 'string', 'min' => 3],
            [['us_email'], 'string', 'max' => 64],
            [['us_email'], 'unique', ],
            [['us_email'], 'email', ],
            [['us_group'], 'in', 'range' => array_keys(self::getGroups()), ],
            [['us_phone'], 'string', 'max' => 24],
            [['us_phone'], 'match', 'pattern' => '|\\+[\\d]+\\([\\d]+\\)[-\\d]{7,9}|'],
            [['us_adr_post', 'us_pass', 'us_city', 'us_org'], 'string', 'max' => 255],
            [['us_group'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'us_id' => 'Us ID',
            'us_active' => 'Активен',
            'us_fam' => 'Фамилия',
            'us_name' => 'Имя',
            'us_otch' => 'Отчество',
            'us_email' => 'Email',
            'us_phone' => 'Телефон',
            'us_adr_post' => 'Адрес доставки',
            'us_birth' => 'Дата рождения',
            'us_pass' => 'Пароль',
            'password' => 'Пароль',
            'us_position' => 'Специализация',
            'us_city' => 'Город',
            'us_org' => 'Организация',
            'us_city_id' => 'Город',
            'us_org_id' => 'Организация',
            'us_created' => 'Создан',
            'us_confirm' => 'Подтвержден',
            'us_activate' => 'Проверен',
            'us_getnews' => 'Инф. об акциях',
            'us_getstate' => 'Инф. о бонусах',
            'us_group' => 'Группа',
            'isAgree' => 'Согласие на обработку данных',
        ];
    }

    public function scenarios() {
        $aRet = parent::scenarios();
        $aRet['backCreateUser'] = [ // регистрирует админ
        ];
        $aRet['register'] = [ // пользователи сами регистрируются
            'us_fam',
            'us_name',
            'us_otch',
            'us_email',
            'us_phone',
            'us_adr_post',
            'us_birth',
            'password',
            'us_position',
            'us_city',
            'us_org',
            'us_getnews',
            'us_getstate',
            'isAgree',
        ];

        $aRet['confirmUserEmail'] = [ // проверка email
            'us_group',
        ];

        $aRet['testUserData'] = [ // проверка пользователя админом
            'us_fam',
            'us_name',
            'us_otch',
            'us_email',
            'us_phone',
            'us_adr_post',
            'us_birth',
            'password',
            'us_position',
            'us_city',
            'us_org',
            'us_city_id',
            'us_org_id',
            'us_group',
        ];

        return $aRet;
    }

    public function getPositions() {
        return [
            1 => 'Врач',
            2 => 'Оптометрист',
            3 => 'Продавец-консультант',
            4 => 'Другое',
        ];
    }

    public static function getGroups($group = null) {
        $a = [
            self::GROUP_NEWREGISTER => 'Неподтвержден',
            self::GROUP_CONFIRMED => 'Непроверен',
            self::GROUP_CLIENT => 'Активен',
            self::GROUP_BLOCKED => 'Заблокирован',
            self::GROUP_OPERATOR => 'Оператор',
            self::GROUP_ADMIN => 'Админ',
        ];
        return ( $group === null ) ? $a : (isset($a[$group]) ? $a[$group] : null);
    }

    public function getGroupName() {
        return self::getGroups($this->us_group);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->us_pass = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates short user name
     *
     * @param string $password
     */
    public function getUserName($bShort = false) {
        $sShort = $this->us_name . (empty($this->us_otch) ? '' : (' ' . $this->us_otch));
        return $bShort ? $sShort : ($this->us_fam . ' ' . $sShort);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
/*
        return static::find()
            ->where([
                'us_id' => $id,
                'us_active' => self::STATUS_ACTIVE,
                'us_group' => [self::GROUP_ADMIN, self::GROUP_OPERATOR, self::GROUP_CLIENT, ],
            ])
            ->one();
*/
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['us_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['us_email' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->us_id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->us_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->us_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        return $this->password === $password;
        return Yii::$app->security->validatePassword($password, $this->us_pass);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->us_key = Yii::$app->security->generateRandomString();
    }

}
