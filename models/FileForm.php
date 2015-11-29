<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class FileForm extends Model
{
    public $filename;
    public $extensions = null;
    public $maxSize = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $aFile = [['filename', ], 'file'];
        $a = ['maxSize', 'extensions'];
        foreach($a As $v) {
            if( $this->{$v} !== null ) {
                $aFile[$v] = $this->$v;
            }
        }
        return [
            // username and password are both required
//            [['filename', ], 'required'],
            $aFile,
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filename' => 'Файл',
        ];
    }


}
