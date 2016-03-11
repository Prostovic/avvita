<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%goodgroup}}".
 *
 * @property integer $gdgrp_id
 * @property integer $gdgrp_gd_id
 * @property integer $gdgrp_grp_id
 */
class Goodgroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%goodgroup}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gdgrp_gd_id', 'gdgrp_grp_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'gdgrp_id' => 'Gdgrp ID',
            'gdgrp_gd_id' => 'Подарок',
            'gdgrp_grp_id' => 'Группа',
        ];
    }
}
