<?php

namespace app\controllers;

use Yii;
use app\models\Orderitem;
use app\models\OrderitemSearch;
use app\models\User;
use app\models\Userorder;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OrderitemController implements the CRUD actions for Orderitem model.
 */
class OrderitemController extends Controller
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
        ];
    }

    /**
     * Lists all Orderitem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderitemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Orderitem model.
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
     * Creates a new Orderitem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orderitem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ordit_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Orderitem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ordit_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Orderitem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $obItem = $this->findModel($id); // ->delete();
        /** @var Userorder $oOrder */
        $oOrder = $obItem->order;
        $obItem->ordit_count = 0;
        $obItem->ordit_gd_id = 0;
        $obItem->ordit_ord_id = 0;
        if( !$obItem->save() ) {
            Yii::error('Error delete order item: ' . print_r($obItem->getErrors(), true));
        }
        else {
            $oOrder->ord_summ = $oOrder->recalcSum();
            if( $oOrder->ord_summ > 0 ) {
                if( $oOrder->save() ) {
                    Yii::error('Error delete order item order error: ' . print_r($oOrder->getErrors(), true));
                }
                $this->redirect(['userorder/view', 'id' => $oOrder->ord_id, ]);
            }
            else {
                $oOrder->delete();
                $this->redirect(['userorder/index',]);
            }
        }

//        $this->redirect(['userorder/confirm', 'id'=>$orderId]);

//        return $this->redirect(['index']);
    }

    /**
     * Finds the Orderitem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orderitem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orderitem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
