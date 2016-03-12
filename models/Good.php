<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use app\models\Orderitem;
use app\models\Goodimg;
use app\components\FilesaveBehavior;
use app\models\Goodgroup;

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

    public $groupid;

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
            [['gd_number', 'gd_active', 'groupid'], 'integer'],
            [['groupid'], 'in', 'range' => array_keys(Group::getAllgroups()), ],
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
            'groupid' => 'Группа',
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

    /**
     *
     */
    public function saveGroup() {
        $sSql = 'Update ' . Goodgroup::tableName()
            . ' Set gdgrp_gd_id = 0, gdgrp_grp_id = 0, gdgrp_order = 0'
            . ' Where gdgrp_gd_id = ' . $this->gd_id;
        Yii::$app->db->createCommand($sSql)->execute();
        $sSql = 'Update ' . Goodgroup::tableName()
            . ' Set gdgrp_gd_id = :goodid, gdgrp_grp_id = :groupid, gdgrp_order = 0'
            . ' Where gdgrp_gd_id = 0'
            . ' Limit 1';
        $n = Yii::$app->db->createCommand($sSql, [':goodid' => $this->gd_id, ':groupid' => $this->groupid])->execute();
        if( $n < 1 ) {
            $ob = new Goodgroup();
            $ob->gdgrp_gd_id = $this->gd_id;
            $ob->gdgrp_grp_id = $this->groupid;
            $ob->gdgrp_order = 0;
            if( !$ob->save() ) {
                Yii::info('Error save goodgroup: '
                    . print_r($ob->getErrors(), true)
                    . "\n"
                    . print_r($ob->attributes, true)
                );
            }
        }

    }
}
