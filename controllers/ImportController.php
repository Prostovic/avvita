<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\FileForm;
use app\components\ExcelConverter;
use yii\web\UploadedFile;
use app\components\XmlConverter;

use app\models\City;
use app\models\Org;
use app\models\Docdata;

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

    /**
     * @return string|\yii\web\Response
     */
    public function actionCity()
    {
        $model = new FileForm();
        $model->extensions = ['xls', 'xlsx',];
        $model->maxSize = 500000;

        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                $oFile = UploadedFile::getInstance($model, 'filename');
                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . time() . '-tmp.' . $oFile->extension; // $oFile->baseName .
//                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . 'tmp.' . $oFile->extension; // $oFile->baseName .
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
                $aMessage = [
                    'class' => 'success',
                    'text' => 'Данные импортированы',
                ];
                try {
                    $oConverter->read();
                }
                catch( \Exception $e ) {
                    Yii::error('Error import City: ' . $e->getMessage());
                    $aMessage = [
                        'class' => 'danger',
                        'text' => 'Ошибка импорта данных',
                    ];
                }
                unlink($sf);
                Yii::$app->session->setFlash($aMessage['class'], $aMessage['text']);
            }
            else {
                Yii::error('Error upload City file: ' . print_r($model->getErrors(), true));
                Yii::$app->session->setFlash('danger', 'Ошибка загрузки файла');
            }
            return $this->refresh();
        }
        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Загрузка данных по Городам',
            'comment' => 'Файл с данными должен содержать 2 колонки с данными: номер и название.<br />' . "\n"
                        . 'Первая строка файла будет проигнорирована (предполагается, что там стоят заголовки колонок).',
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionOrg()
    {
        $model = new FileForm();
        $model->extensions = ['xls', 'xlsx',];
        $model->maxSize = 500000;

        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                $oFile = UploadedFile::getInstance($model, 'filename');
                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . time() . '-tmp.' . $oFile->extension; // $oFile->baseName .
//                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . 'tmp.' . $oFile->extension; // $oFile->baseName .
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
                $aMessage = [
                    'class' => 'success',
                    'text' => 'Данные импортированы',
                ];
//            Yii::info('File: ' . $sf);
                try {
                    $oConverter->read();
                }
                catch( \Exception $e ) {
                    Yii::error('Error import Org: ' . $e->getMessage());
                    $aMessage = [
                        'class' => 'danger',
                        'text' => 'Ошибка импорта данных',
                    ];
                }
                unlink($sf);
                Yii::$app->session->setFlash($aMessage['class'], $aMessage['text']);
            }
            else {
                Yii::error('Error upload Org file: ' . print_r($model->getErrors(), true));
                Yii::$app->session->setFlash('danger', 'Ошибка загрузки файла');
            }
            return $this->refresh();
        }
        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Загрузка данных по Организациям',
            'comment' => 'Файл с данными должен содержать 2 колонки с данными: номер и название.<br />' . "\n"
                . 'Первая строка файла будет проигнорирована (предполагается, что там стоят заголовки колонок).',
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionData() {
        $model = new FileForm();
        $model->extensions = ['xml', ];
        $model->maxSize = 500000;

        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                $oFile = UploadedFile::getInstance($model, 'filename');
            $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . time() . '-tmp.' . $oFile->extension; // $oFile->baseName .
//                $sf = Yii::getAlias('@app/runtime') . DIRECTORY_SEPARATOR . 'tmp.' . $oFile->extension; // $oFile->baseName .
                $oFile->saveAs($sf);
                Yii::trace('File: ' . $sf . ' ' . (file_exists($sf) ? ' OK' : ' FAIL'));

                $oConverter = new XmlConverter();
                $oConverter->className = Docdata::className();
                $oConverter->filePath = $sf;
                $oConverter->fields = [
                    'doc_key' => 'НомерДокумента',
                    'doc_date' => 'ДатаДокумента',
                    'doc_fullordernum' => 'ПолныйНомерЗаказа',
                    'doc_ordernum' => 'НомерЗаказа',
                    'doc_org_id' => 'КодКонтрагента',
                    'doc_title' => 'НоменклатураХарактеристика',
                    'doc_number' => 'Количество',
                    'doc_summ' => 'Сумма',
                ];
                $oConverter->keyfields = ['doc_key', ];
//            Yii::info('File: ' . $sf);
                $bOk = $oConverter->read();
                unlink($sf);
                if( $bOk ) {
                    Yii::$app->session->setFlash('success', 'Данные импортированы');
                }
            }
            else {
                Yii::error('Error validate file: ' . print_r($model->getErrors(), true));
                Yii::$app->session->setFlash('danger', 'Error validate file: ' . print_r($model->getErrors(), true));
            }
            return $this->refresh();
        }

        $sTestData = <<<EOT
<BONUSES>
	<BONUS НомерДокумента="30051500010" ДатаДокумента="01.06.2015" ПолныйНомерЗаказа="АВВ-038672" НомерЗаказа="406001006" КодКонтрагента="000000871" НоменклатураХарактеристика="Multigressiv Mono 1.60 - STK, -04.00,  -1.00,  0.00,  70,  Ultrasin,  Безфильтра,  R" Количество="1" Сумма="5"/>
</BONUSES>
EOT;

        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Импорт xml по заказам',
            'comment' => 'Файл должет содержать структуру, аналогичную следующей:<br />' . "\n"
                        . nl2br(Html::encode($sTestData)),
        ]);
    }

}
