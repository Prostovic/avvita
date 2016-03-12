<?php

namespace app\models;

use Yii;
use yii\base\InvalidParamException;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "{{%group}}".
 *
 * @property integer $grp_id
 * @property string $grp_title
 * @property string $grp_imagepath
 * @property string $grp_description
 * @property integer $grp_active
 * @property integer $grp_order
 * @property string $grp_created
 */
class Group extends \yii\db\ActiveRecord
{
    public $file = null;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['grp_created'],
                ],
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'grp_order',
                ],
                'value' => function ($event) {
                    /** @var \yii\base\Event $event */

                    $nVal =  Yii::$app->db->createCommand('Select MAX(grp_order) + 1 As nextorder From ' . Group::tableName())->queryScalar();
                    return $nVal ? $nVal : 1;
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%group}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['grp_title', ], 'required'],
            [['grp_description'], 'string'],
            [['grp_active', 'grp_order', ], 'integer'],
            [['grp_created'], 'safe'],
            [['grp_title', 'grp_imagepath'], 'string', 'max' => 255],
            [['file'], 'safe'],
            [['file'], 'file', 'maxFiles' => 1, 'maxSize' => Yii::$app->params['image.maxsize'], 'extensions' => Yii::$app->params['image.ext']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'grp_id' => 'Grp ID',
            'grp_title' => 'Наименование',
            'grp_imagepath' => 'Изображение',
            'grp_description' => 'Описание',
            'grp_active' => 'Показать',
            'grp_created' => 'Создана',
            'grp_order' => 'Порядок',
            'file' => 'Картинка',
        ];
    }

    /**
     * Сохраняем файл
     * @param UploadedFile $obFile
     */
    public function saveFile($obFile) {
        if( $obFile === null ) {
            return true;
        }
        $sDir = Yii::getAlias('@webroot/images/gr');
        if( !is_dir($sDir) ) {
            if( !mkdir($sDir) ) {
                throw new InvalidParamException('Каталог для картинок не существует');
            }
            else {
                chmod($sDir, 0777);
            }
        }
        $sf = $sDir . DIRECTORY_SEPARATOR . $this->grp_id . '.' . $obFile->extension;
        if( $obFile->saveAs($sf) ) {
            $this->grp_imagepath = str_replace('\\', '/', substr($sf, strlen(Yii::getAlias('@webroot'))));
            $this->save();
        }
    }
}
