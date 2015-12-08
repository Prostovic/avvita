<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\FileForm;
use app\components\ExcelConverter;
use yii\web\UploadedFile;

use app\models\City;
use app\models\Org;


class ImportController extends Controller
{
/*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
*/

    public function actionCity()
    {
        $model = new FileForm();
        $model->extensions = ['xls', 'xlsx',];
        $model->maxSize = 500000;

        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                $oFile = UploadedFile::getInstance($model, 'filename');
//            $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . time() . '-tmp.' . $oFile->extension; // $oFile->baseName .
                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . 'tmp.' . $oFile->extension; // $oFile->baseName .
                $oFile->saveAs($sf);
                Yii::info('File: ' . $sf . ' ' . (file_exists($sf) ? ' OK' : ' FAIL'));
                $oConverter = new ExcelConverter();
                $oConverter->startRow = 1;
                $oConverter->className = City::className();
                $oConverter->filePath = $sf;
                $oConverter->fields = [
                    'city_key' => 0,
                    'city_name' => 1,
                ];
                $oConverter->keyfields = ['city_key', ];
//            Yii::info('File: ' . $sf);
                $oConverter->read();
                unlink($sf);
            }
            else {
                Yii::$app->session->setFlash('danger', 'Error validate file: ' . print_r($model->getErrors(), true));
            }
            return $this->refresh();
        }
        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Загрузка данных по Городам',
        ]);
    }

    public function actionOrg()
    {
        $model = new FileForm();
        $model->extensions = ['xls', 'xlsx',];
        $model->maxSize = 500000;

        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                $oFile = UploadedFile::getInstance($model, 'filename');
//            $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . time() . '-tmp.' . $oFile->extension; // $oFile->baseName .
                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . 'tmp.' . $oFile->extension; // $oFile->baseName .
                $oFile->saveAs($sf);
                Yii::info('File: ' . $sf . ' ' . (file_exists($sf) ? ' OK' : ' FAIL'));
                $oConverter = new ExcelConverter();
                $oConverter->startRow = 1;
                $oConverter->className = Org::className();
                $oConverter->filePath = $sf;
                $oConverter->fields = [
                    'org_key' => 1,
                    'org_name' => 2,
                ];
                $oConverter->keyfields = ['org_key', ];
//            Yii::info('File: ' . $sf);
                $oConverter->read();
                unlink($sf);
            }
            else {
                Yii::$app->session->setFlash('danger', 'Error validate file: ' . print_r($model->getErrors(), true));
            }
            return $this->refresh();
        }
        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Загрузка данных по Организациям',
        ]);
    }

}
