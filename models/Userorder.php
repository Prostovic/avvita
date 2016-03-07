<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

use app\components\ActionBehavior;
use app\components\Notificator;

/**
 * This is the model class for table "{{%userorder}}".
 *
 * @property integer $ord_id
 * @property integer $ord_us_id
 * @property double $ord_summ
 * @property integer $ord_flag
 * @property string $ord_created
 * @property string $ord_message
 */
class Userorder extends ActiveRecord
{
    const ORDER_FLAG_DELETED = 0;
    const ORDER_FLAG_ACTVE = 1;
    const ORDER_FLAG_COMPLETED = 2;
    const ORDER_FLAG_SENDED = 3;

    public $_oldFlag = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['ord_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => ActionBehavior::className(),
                'allevents' => [ActiveRecord::EVENT_AFTER_FIND],
                'action' => function($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    $model->_oldFlag = $model->ord_flag;
                }
            ],
            [
                'class' => ActionBehavior::className(),
                'allevents' => [ActiveRecord::EVENT_AFTER_UPDATE],
                'action' => function($event) {
                    /** @var \yii\base\Event $event */
                    $model = $event->sender;
                    $old = $model->_oldFlag;
                    $new = $model->ord_flag;
                    if( ($old != $new) && ($new == Userorder::ORDER_FLAG_COMPLETED) ) {
                        $aUsers = User::findAll(['us_group' => [User::GROUP_ADMIN, User::GROUP_OPERATOR,] ]);
                        $oNotify = new Notificator(
                            $aUsers,
                            $model,
                            'ordermade_mail'
                        );
                        $oNotify->notifyMail('Новый заказ на сайте "' . Yii::$app->name . '"');
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
        return '{{%userorder}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ord_us_id', ], 'required'],
            [['ord_us_id', 'ord_flag', ], 'integer'],
            [['ord_id'], 'integer', 'skipOnEmpty'=>true],
            [['ord_summ'], 'number'],
            [['ord_created'], 'safe'],
            [['ord_message'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ord_id' => 'Номер',
            'ord_us_id' => 'Клиент',
            'ord_summ' => 'Сумма',
            'ord_flag' => 'Состояние',
            'ord_created' => 'Создан',
            'items' => 'Состав',
            'ord_message' => 'Сообщение',
        ];
    }

    /**
     * Получение текущего заказа пользователя
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $uid текущий заказ пользователя
     * @return Userorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function getActiveOrder($uid = null)
    {
        if( $uid === null ) {
            $uid = Yii::$app->user->getId();
        }

        $model = self::find()
            ->where(['ord_us_id' => $uid, 'ord_flag' => self::ORDER_FLAG_ACTVE])
            ->one();
        if( $model === null ) {
            $model = self::find()
                ->where(['ord_flag' => self::ORDER_FLAG_DELETED])
                ->one();
            if( $model === null ) {
                $model = new Userorder();
            }
            else {
                $model->ord_created = new Expression('NOW()');
            }
            $model->ord_us_id = $uid;
            $model->ord_flag = self::ORDER_FLAG_ACTVE;
            if( !$model->save() ) {
                throw new NotFoundHttpException('User order does not exists.');
            }
        }
        return $model;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems() {
        return $this->hasMany(
            Orderitem::className(),
            ['ordit_ord_id' => 'ord_id']
        )->inverseOf('order');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoods() {
        return $this->hasMany(
            Orderitem::className(),
            ['ordit_ord_id' => 'ord_id']
        )->inverseOf('order')->with(['good']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(
            User::className(),
            ['us_id' => 'ord_us_id']
        );
    }

    /**
     * @return array
     */
    public static function getOrderStates() {
        return [
            self::ORDER_FLAG_DELETED => 'Удален',
            self::ORDER_FLAG_ACTVE => 'Активный',
            self::ORDER_FLAG_COMPLETED => 'Сформирован',
            self::ORDER_FLAG_SENDED => 'Отправлен',
        ];

    }

    /**
     * @return string
     */
    public function getStatetitle() {
        $a = self::getOrderStates();
        return isset($a[$this->ord_flag]) ? $a[$this->ord_flag] : '???';
    }

    /**
     *
     */
    public function recalcSum() {
        $nSumm = 0;
        foreach($this->goods As $obItem) {
            /** @var Orderitem $obItem */
            $nSumm += $obItem->ordit_count * $obItem->good->gd_price;
        }
        return $nSumm;
    }
}
