<?php

namespace app\controllers;

use Yii;
use app\models\Userorder;
use app\models\UserorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;

use app\models\User;

/**
 * UserorderController implements the CRUD actions for Userorder model.
 */
class UserorderController extends Controller
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
                'only' => ['index', 'update', 'delete', 'list', 'append', ], // 'view', 'delete',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'append', 'update', ],
                        'roles' => [ User::GROUP_CLIENT, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'delete', ],
                        'roles' => [User::GROUP_OPERATOR],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Userorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Userorder models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new UserorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userorder model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Userorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userorder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ord_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Добавление к заказу товара
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id id товара
     * @return mixed
     */
    public function actionAppend($id)
    {
        $model = Userorder::getActiveOrder();

        if( !$model->addGood($id) ) {
            return $this->render('error', [
                'model' => $model,
            ]);
        }

        return $this->goBack();
    }

    /**
     * Updates an existing Userorder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ord_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Userorder model.
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
     * Finds the Userorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userorder::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
