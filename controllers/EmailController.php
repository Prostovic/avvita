<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;

use app\models\User;

class EmailController extends Controller
{
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => [User::GROUP_OPERATOR],
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

    /**
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', ['files' => $this->getList()]);
    }

    /**
     * @return array
     */
    public function getList() {
        $aRet = [];
        $sDir = Yii::getAlias('@runtime/mail');
        $tDel = time() - 2 * 24 * 3600;
        if( $hd = opendir($sDir) ) {
            while (false !== ($file = readdir($hd))) {
                if( ($file == '.') || ($file == '..') ) {
                    continue;
                }

                $sf = $sDir . DIRECTORY_SEPARATOR . $file;
                $tFile = filemtime($sf);
                if( $tFile < $tDel ) {
                    unlink($sf);
                    continue;
                }
                $aRet[] = ['name' => $file, 'time' => $tFile];
            }
            closedir($hd);
            usort($aRet, function($a, $b){ return $a['time'] < $b['time'] ? 1 : -1; });
        }
        return $aRet;
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionGet()
    {
        $sName = Yii::$app->request->getQueryParam('fname', 'noname');
        $sDir = Yii::getAlias('@runtime/mail');
        $sf = $sDir . DIRECTORY_SEPARATOR . $sName;
        if( !file_exists($sf) ) {
            throw new NotFoundHttpException('Файл ' . $sName . ' не найден');
        }

        Yii::$app->response->sendFile($sf);
//        Yii::app()->getRequest()->sendFile($sName, file_get_contents($sf));

    }

}
