<?php

namespace app\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\web\Response;
use yii\widgets\ActiveForm;

use app\models\Group;
use app\models\GroupSearch;
use app\models\User;
use app\models\GoodSearch;

/**
 * GroupController implements the CRUD actions for Group model.
 */
class GroupController extends Controller
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
                'only' => ['index', 'view', 'create', 'update', 'delete', 'deletefile', 'list', 'goods', ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'goods', ],
                        'roles' => ['?', User::GROUP_CLIENT, User::GROUP_OPERATOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'update', 'delete', 'list', 'deletefile', ],
                        'roles' => [User::GROUP_OPERATOR],
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionList()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $aVals = Yii::$app->db->createCommand('Select MIN(grp_order) As minval, MAX(grp_order) As maxval From ' . Group::tableName())->queryOne(\PDO::FETCH_ASSOC);

        list($nMinOrder, $nMaxOrder) = (is_array($aVals) && (count($aVals) > 1)) ? array_values($aVals) : [0, 0];

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'nMinOrder' => $nMinOrder,
            'nMaxOrder' => $nMaxOrder,
        ]);
    }

    /**
     * Lists all Group models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Group goods.
     * @return mixed
     */
    public function actionGoods($id)
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search([$searchModel->formName() => ['groupid' => $id], ]);

        return $this->render('//good/userindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Group model.
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
     * Creates a new Group model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->actionUpdate(0);
//        $model = new Group();
//
//        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            return ActiveForm::validate($model);
//        }
//
//        if ($model->load(Yii::$app->request->post()) ) {
//            if( $model->save() ) {
//                $model->saveFile(UploadedFile::getInstance($model, 'file'));
//                return $this->redirect(['list', ]);
////                return $this->redirect(['view', 'id' => $model->grp_id]);
//            }
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
    }

    /**
     * Updates an existing Group model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( $id == 0 ) {
            $model = new Group();
        }
        else {
            $model = $this->findModel($id);
            $model->_goods = ArrayHelper::map($model->groupgoods, 'gdgrp_gd_id', 'gdgrp_gd_id');
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) ) {
            if( $model->save() ) {
                $model->saveFile(UploadedFile::getInstance($model, 'file'));
                $model->saveGoods();
                return $this->redirect(['list', ]);
//                return $this->redirect(['view', 'id' => $model->grp_id]);
            }
        }

        return $this->render($id == 0 ? 'create' : 'update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Group model.
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
     * @param integer $id
     * @return Response
     */
    public function actionDown($id) {
        return $this->actionUp($id, false);
    }

    /**
     * @param integer $id
     * @param bool $bUp
     * @return Response
     */
    public function actionUp($id, $bUp = true)
    {
        $model = $this->findModel($id);
        $sSql = 'Select grp_id, grp_order From '
            . Group::tableName()
            . ' Where grp_order ' . ($bUp ? '<' : '>') . ' ' . $model->grp_order
            . ' Order By grp_order ' . ($bUp ? 'DESC' : 'ASC')
            . ' Limit 1';

        $aVals = Yii::$app->db->createCommand($sSql)->queryOne(\PDO::FETCH_ASSOC);

        if( $aVals !== null ) {
            $ob = $this->findModel($aVals['grp_id']);
            $ob->grp_order = $model->grp_order;
            $model->grp_order = $aVals['grp_order'];
            if( !$ob->save() ) {
                Yii::info('Error save Group ob after up: ' . print_r($ob->getErrors(), true));
            }
            else {
                if( !$model->save() ) {
                    Yii::info('Error save Group model after up: ' . print_r($model->getErrors(), true));
                }
            }
        }

        return $this->redirect(['list']);
    }

    /**
     * @param integer $id
     * @return Response
     */
    public function actionDeletefile($id)
    {
        $model = $this->findModel($id);
        $model->deleteFile();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [];
    }

    /**
     * Finds the Group model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Group the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Group::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
