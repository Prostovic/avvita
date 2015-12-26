<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\base\Event;
use yii\db\Expression;
use yii\db\ActiveRecord;

use app\components\Notificator;

/**
 * This is the model class for table "{{%userdata}}".
 *
 * @property integer $ud_id
 * @property integer $ud_doc_id
 * @property integer $ud_us_id
 * @property string $ud_created
 * @property string $ud_doc_key
 */
class Userdata extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['ud_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_INSERT => ['ud_created'],
                ],
                'value' => function ($event){
                    /** @var Event $event */
                    /** @var Userdata $model */
                    $model = $event->sender;
                    $aExists = self::find()
                        ->where([
                            'and',
                            ['=', 'ud_doc_key', $model->ud_doc_key],
                            ['<>', 'ud_us_id', Yii::$app->user->getId()]
                        ])
                        ->all();
                    $nCou = count($aExists);
                    if( $nCou > 0 ) {
                        $oNotify = new Notificator(
                            User::findAll(['us_group' => [User::GROUP_ADMIN, User::GROUP_OPERATOR,]]),
                            $model, // $aExists,
                            'duplicateorder_mail'
                        );
                        $oNotify->notifyMail('Вы проверены на портале "' . Yii::$app->name . '"');
                    }
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%userdata}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ud_us_id', 'ud_doc_key'], 'required'], // 'ud_doc_id',
            [['ud_doc_id', 'ud_us_id'], 'integer'],
            [['ud_created'], 'safe'],
            [['ud_doc_key'], 'string', 'max'=>255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ud_id' => 'Ud ID',
            'ud_doc_id' => 'Документ',
            'ud_us_id' => 'Пользователь',
            'ud_created' => 'Создан',
            'ud_doc_key' => 'Номер заказа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocs() {
        return $this->hasMany(Docdata::className(), ['doc_key' => 'ud_doc_key']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['us_id' => 'ud_us_id']);
    }

}
