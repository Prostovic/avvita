<?php

namespace app\models;

use app\components\Notificator;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use app\components\ActionBehavior;
use yii\db\Expression;

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
class User extends ActiveRecord
{
    const GROUP_NEWREGISTER = 'newuser';
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
                    ActiveRecord::EVENT_BEFORE_INSERT => 'us_birth',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'us_birth',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    if( preg_match('|^([\\d]+).([\\d]+).([\\d]+)$|', $model->us_birth, $a) ) {
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
            [['us_fam', 'us_name', 'us_email', 'us_adr_post', 'us_birth', 'us_position', 'us_city', 'us_org', 'us_getnews', 'us_getstate', 'isAgree', ], 'required'],
            [['isAgree', ], 'compare', 'compareValue' => 1, 'message' => 'Необходимо отметить {attribute}'],
            [['password', ], 'required', 'on'=>['register']],
            [['us_active', 'us_position', 'us_getnews', 'us_getstate'], 'integer'],
            [['us_birth', 'us_created', 'us_confirm', 'us_activate'], 'safe'],
            [['us_fam', 'us_name', 'us_otch'], 'string', 'max' => 32],
            [['password'], 'string', 'min' => 3],
            [['us_email'], 'string', 'max' => 64],
            [['us_phone'], 'string', 'max' => 24],
            [['us_adr_post', 'us_pass', 'us_city', 'us_org'], 'string', 'max' => 255],
            [['us_city_id', 'us_org_id', 'us_group'], 'string', 'max' => 16]
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
            'us_city_id' => 'id города',
            'us_org_id' => 'id организации',
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
        return [
            'backCreateUser' => [ // регистрирует админ
            ],
            'register' => [ // пользователи сами регистрируются
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
            ],
        ];
    }

    public function getPositions() {
        return [
            1 => 'Врач',
            2 => 'Оптометрист',
            3 => 'Продавец-консультант',
            4 => 'Другое',
        ];
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
}
