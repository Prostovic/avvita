<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\FileForm;

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

        if( $model->load(Yii::$app->request->post()) && $model->validate() ) {
            return $this->refresh();
        }
        return $this->render('fileform', [
            'model' => $model,
            'title' => 'Загрузка данных по Городам',
        ]);
    }

}
