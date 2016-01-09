<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use app\models\Orderitem;
use app\models\Goodimg;
use app\components\FilesaveBehavior;

/**
 * This is the model class for table "{{%good}}".
 *
 * @property integer $gd_id
 * @property string $gd_title
 * @property string $gd_imagepath
 * @property string $gd_description
 * @property double $gd_price
 * @property integer $gd_number
 * @property integer $gd_active
 * @property string $gd_created
 */
class Good extends \yii\db\ActiveRecord
{
    public $file = null;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['gd_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'fileSave' => [
                'class' => FilesaveBehavior::className(),
                'filesaveFileModel' => 'app\models\Goodimg',
                'filesaveConvertFields' => [
                    'gi_title' => 'name',
//                    'file_size' => 'size',
//                    'file_type' => 'type',
                    'gi_path' => 'fullpath',
                    'gi_gd_id' => 'parentid',
//                    'file_us_id' => Yii::$app->user->getId(),
                ],
                'filesaveBaseDirName' => '@webroot/images/gd'
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%good}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gd_title', 'gd_price', ], 'required'],
            [['gd_description'], 'string'],
            [['gd_price'], 'number'],
            [['gd_number', 'gd_active'], 'integer'],
            [['gd_created'], 'safe'],
            [['gd_title', 'gd_imagepath'], 'string', 'max' => 255],
            [['file'], 'safe'],
            [['file'], 'file', 'maxFiles' => Yii::$app->params['image.count'], 'maxSize' => Yii::$app->params['image.maxsize'], 'extensions' => Yii::$app->params['image.ext']],        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gd_id' => 'ID',
            'gd_title' => 'Наименование',
            'gd_imagepath' => 'Изображение',
            'gd_description' => 'Описание',
            'gd_price' => 'Стоимость',
            'gd_number' => 'Кол-во',
            'gd_active' => 'Показать',
            'gd_created' => 'Создан',
            'items' => 'В заказах',
            'ordered' => 'Заказано',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItems() {
        return $this->hasMany(
            Orderitem::className(),
            [
                'ordit_gd_id' => 'gd_id'
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrdered() {
        return $this
            ->getItems()
            ->sum('ordit_count');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages() {
        return $this->hasMany(
            Goodimg::className(),
            [
                'gi_gd_id' => 'gd_id'
            ]
        );
    }
}
