<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\models\Userdata;
use app\models\UserdataSearch;
use app\models\OrderForm;

use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\widgets\ActiveForm;
use yii\web\Response;
use app\components\Orderhelper;

/**
 * UserdataController implements the CRUD actions for Userdata model.
 */
class UserdataController extends Controller
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
                'only' => ['index', 'view', 'create', 'delete', ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', ],
                        'roles' => [User::GROUP_OPERATOR, User::GROUP_CLIENT, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'view', ],
                        'roles' => [User::GROUP_CLIENT, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', ],
                        'roles' => [User::GROUP_OPERATOR, ],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Userdata models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserdataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userdata model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if( !Yii::$app->user->can(User::GROUP_OPERATOR)
         && ($model->ud_us_id != Yii::$app->user->getId()) ) {
            throw new ForbiddenHttpException('У Вас нет доступа к данной странице');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Userdata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Orderhelper::getActiveOrderData(true);
            return $this->redirect(['index', ]);
        } else {
            return $this->render('append', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Userdata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ud_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Userdata model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Userdata model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userdata the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userdata::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
