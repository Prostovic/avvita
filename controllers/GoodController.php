<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use app\models\Good;
use app\models\GoodSearch;
use app\models\Goodimg;
use app\models\User;

/**
 * GoodController implements the CRUD actions for Good model.
 */
class GoodController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'list', ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', ],
                        'roles' => ['?', User::GROUP_CLIENT, User::GROUP_OPERATOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'list', ],
                        'roles' => [User::GROUP_OPERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Good models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Good models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Url::remember();

        return $this->render('userindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Good model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Url::remember();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Good model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Good();
        $model->loadDefaultValues();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFile($model->gd_id);
            return $this->redirect(['list', ]);
//            return $this->redirect(['view', 'id' => $model->gd_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Good model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadFile($model->gd_id);
            return $this->redirect(['list', ]);
//            return $this->redirect(['view', 'id' => $model->gd_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Good model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
//        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @return string
     */
    public function actionDeletefile($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = $this->findModel($id);
        $fileId = Yii::$app->request->getQueryParam('fileid', -1);
        $bDel = false;
        foreach($model->images As $ob) {
            /** @var Goodimg $ob */
            if( $ob->gi_id == $fileId ) {
                $sRoorDir = str_replace('/', DIRECTORY_SEPARATOR, Yii::getAlias('@webroot'));
                $sf = $sRoorDir . str_replace('/', DIRECTORY_SEPARATOR, $ob->gi_path);
                if( file_exists($sf) ) {
                    unlink($sf);
                    $ob->delete();
//                    Yii::info('actionDeletefile('.$id.') : delete file ' . $sf . ' ('.$ob->file_id.')');
                    $bDel = true;
                }
                else {
                    Yii::info('actionDeletefile('.$id.') : not exists file ' . $sf . ' ('.$sRoorDir.' + '.$ob->gi_path.')');
                }
            }
        }
        return $bDel ? [] : ['error' => 'Not delete file'];
    }

    /**
     * Finds the Good model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Good the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Good::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
