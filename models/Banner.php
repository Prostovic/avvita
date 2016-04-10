<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

use app\components\FilesaveBehavior;

/**
 * This is the model class for table "{{%banner}}".
 *
 * @property integer $bnr_id
 * @property integer $bnr_active
 * @property string $bnr_imagepath
 * @property string $bnr_group
 * @property string $bnr_title
 * @property string $bnr_description
 * @property string $bnr_created
 * @property integer $bnr_order
 */
class Banner extends \yii\db\ActiveRecord
{
    public $file = null;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['bnr_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            'fileSave' => [
                'class' => FilesaveBehavior::className(),
//                'filesaveFileModel' => 'app\models\Banner',
                'filesaveConvertFields' => [
                    'bnr_imagepath' => 'fullpath',
                ],
                'filesaveBaseDirName' => '@webroot/images/rotate',
                'filesaveCreateFullPath' => function($basePath, $sFilename, $modelId) {
                    $sSubdir = str_pad($modelId % 256, 2, '0', STR_PAD_LEFT) ;
                    $sDir = str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias($this->filesaveBaseDirName))
                        . DIRECTORY_SEPARATOR
                        . $sSubdir;
                    if( !is_dir($sDir) && !@mkdir($sDir) ) {
                        Yii::info('Does not exists directory ' . $sDir . ' ('.$sFilename.')');
                        return null;
                    }
                    else {
                        chmod($sDir, 0777);
                    }
                    return $sDir . DIRECTORY_SEPARATOR . $sFilename;
                }
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%banner}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bnr_active', 'bnr_order'], 'integer'],
            [['bnr_description'], 'string'],
            [['bnr_created'], 'safe'],
            [['bnr_imagepath', 'bnr_group', 'bnr_title'], 'string', 'max' => 255],
            [['file'], 'file', 'maxFiles' => Yii::$app->params['image.count'], 'maxSize' => Yii::$app->params['image.maxsize'], 'extensions' => Yii::$app->params['image.ext']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bnr_id' => 'Bnr ID',
            'bnr_active' => 'Показать',
            'bnr_imagepath' => 'Изображение',
            'bnr_group' => 'Группа',
            'bnr_title' => 'Заголовок',
            'bnr_description' => 'Описание',
            'bnr_created' => 'Создана',
            'bnr_order' => 'Порядок',
        ];
    }

    /**
     *
     */
    public function unlinkOldFile()
    {
        if( !empty($this->bnr_imagepath) ) {
            $sf = Yii::getAlias('@webroot')
                . DIRECTORY_SEPARATOR
                . $this->bnr_imagepath;
            if( file_exists($sf) ) {
                unlink($sf);
            }
        }
    }

    /**
     *
     */
    public function setNewFile($sFile)
    {
        $this->unlinkOldFile();
        $this->bnr_imagepath = $sFile;
        return $this->save();
    }

    /*
     *
     */
    public static function getAllGroups() {
        return Yii::$app
            ->db
            ->createCommand('Select Distinct bnr_group From ' . self::tableName() . ' Order By bnr_group')
            ->queryAll(\PDO::FETCH_ASSOC);
    }
}
