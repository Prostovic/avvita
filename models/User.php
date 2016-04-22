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
 * @property string $us_op_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    const GROUP_NEWREGISTER = 'newuser';
    const GROUP_CONFIRMED = 'confitmed';
    const GROUP_CLIENT = 'client';
    const GROUP_BLOCKED = 'blocked';
    const GROUP_OPERATOR = 'operator';
    const GROUP_ADMIN = 'admin';
    const GROUP_DELETED = 'del';

    public $isAgree;
    public $password = '';

    public $docSumm = 0;
    public $orderSumm = 0;
    public $commonSumm = 0;


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
                    return ( $model->scenario == 'register' ) ? User::GROUP_NEWREGISTER : $model->us_group;
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
            [['password', ], 'required', 'on'=>['register', 'setnewpassword', ]],
            [['password', ], 'required', 'when'=> function($model) { return $model->isNewRecord; }],
            [['us_active', 'us_position', 'us_getnews', 'us_getstate', 'us_city_id', 'us_org_id', ], 'integer'],
            [['us_birth', 'us_created', 'us_confirm', 'us_activate'], 'safe'],
            [['us_fam', 'us_name', 'us_otch'], 'string', 'max' => 32],
            [['password'], 'string', 'min' => 3],
            [['us_email'], 'string', 'max' => 64],
            [['us_email'], 'uniqueEmail', ],
            [['us_email'], 'email', ],
            [['us_group'], 'in', 'range' => array_keys(self::getGroups()), ],
            [['us_phone'], 'string', 'max' => 24],
            [['us_phone'], 'match', 'pattern' => '|\\+[\\d]+\\([\\d]+\\)[-\\d]{7,9}|'],
            [['us_adr_post', 'us_pass', 'us_city', 'us_org', 'us_op_key', ], 'string', 'max' => 255],
            [['us_group'], 'string', 'max' => 16]
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function uniqueEmail($attribute, $params) {
        $nValues = Yii::$app
            ->db
            ->createCommand(
                'Select COUNT(*) From '.self::tableName().' Where '.$attribute.' = :email And us_group <> :gr_deleted',
                [':email' => $this->{$attribute}, ':gr_deleted' => User::GROUP_DELETED]
            )
            ->queryScalar();
        $nMax = $this->isNewRecord ? 0 : 1;
        if( $nValues > $nMax ) {
            $this->addError($attribute, 'Пользователь с таким Email уже существует.'); //  ('.$nValues.' > '.$nMax.')
        }
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
            'us_op_key' => 'Ключ на действия',
            'docSumm' => 'Начисления',
        ];
    }

    /**
     * @return array
     */
    public function scenarios() {
        $aRet = parent::scenarios();

        $aRet['backCreateUser'] = [ // регистрирует админ
            'us_fam',
            'us_name',
            'us_otch',
            'us_email',
            'password',
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

        $aRet['profile'] = [ // профиль
            'us_fam',
            'us_name',
            'us_otch',
            'us_email',
            'us_phone',
            'password',
            'us_birth',
        ];

        $aRet['profile'] = [ // профиль
            'us_fam',
            'us_name',
            'us_otch',
            'us_email',
            'us_phone',
            'password',
            'us_birth',
        ];

        if( ($this->scenario == 'profile') && !Yii::$app->user->can(self::GROUP_OPERATOR) ) {
            $aRet['profile'] = array_merge(
                $aRet['profile'],
                [
                    'us_adr_post',
                    'us_position',
                    'us_city',
                    'us_org',
                ]
            );
        }

        $aRet['confirmUserEmail'] = [ // проверка email
            'us_group',
        ];

        $aRet['setnewpassword'] = [ // новый пароль
            'password',
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

    /**
     *
     */
    public function setScenarioAttr() {
        $aValues = [
            'backCreateUser' => [
                'us_active' => 1,
                'us_group' => User::GROUP_OPERATOR,
            ],
        ];
        Yii::info('Set scenario ' . $this->scenario . ' = ' . (isset($aValues[$this->scenario]) ? 'set' : 'none'));
        if( isset($aValues[$this->scenario]) ) {
            foreach( $aValues[$this->scenario] As $k=>$v ) {
                $this->{$k} = $v;
            }
        }
    }
    /**
     * @return array
     */
    public function getPositions() {
        return [
            1 => 'Врач',
            2 => 'Оптометрист',
            3 => 'Продавец-консультант',
            4 => 'Другое',
        ];
    }

    /**
     * @param null $group
     * @return array|null
     */
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

    /**
     * @return array|null
     */
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
        return self::find()->where([
            'and',
            ['us_email' => $username],
            ['<>', 'us_group', User::GROUP_DELETED]
        ])->one();
    }

    /**
     * Finds user by us_op_key
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByOpkey($opkey)
    {
        return self::findOne(['us_op_key' => $opkey]);
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

    /**
     * Список пользователей оределенной группы или групп
     * @param string|array $sType
     * @return array
     */
    public static function getUserList($sType = self::GROUP_CLIENT) {
        static $aGroups = [];
        $sKey = is_array($sType) ? implode('_', asort($sType)) : $sType;
        if( !isset($aGroups[$sKey]) ) {
            $aGroups[$sKey] = self::find()->where(['us_group' => $sType])->all();
        }
        return $aGroups[$sKey];
    }


    /**
     * Связь с табличкой на сопоставление заказа и пользователя
     * @return \yii\db\ActiveQuery
     */
    public function getUserdata() {
        return $this->hasMany(
            Userdata::className(),
            ['ud_us_id' => 'us_id', ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocdata() {
        return $this->hasMany(Docdata::className(), ['doc_id' => 'ud_doc_id'])->via('userdata');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrders() {
        return $this->hasMany(
            Userorder::className(),
            ['ord_us_id' => 'us_id']
        );
    }

    /**
     *
     */
    public function getSumdocQuery($aCond = []) {
        $query = self::find()
            ->leftJoin(Userdata::tableName(), 'ud_us_id=us_id')
            ->leftJoin(Docdata::tableName(), 'doc_key=ud_doc_key')
            ->leftJoin(Userorder::tableName(), 'ord_us_id=us_id')
            ->select(
                [
                    self::tableName().'.*',
                    'SUM('.Docdata::tableName().'.doc_summ) AS docSumm',
                    'SUM('.Userorder::tableName().'.ord_summ) AS orderSumm',
//                    'docSumm - orderSumm AS commonSumm',
                ]
            )
            ->groupBy(self::tableName().'.us_id');
        return $query;

//            ->where(
//                [
//                    'and',
//                    [self::tableName().'.us_group' => User::GROUP_CLIENT, ],
//                    ['not in', 'us_group', [User::GROUP_DELETED], ],
//                ]
//            )
    }

}
