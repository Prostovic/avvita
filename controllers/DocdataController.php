<?php

namespace app\controllers;

use app\components\Orderhelper;
use Yii;
Use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Userdata;
use app\models\Docdata;
use app\models\DocdataSearch;
use app\models\User;

/**
 * DocdataController implements the CRUD actions for Docdata model.
 */
class DocdataController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'delete', ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', ],
                        'roles' => [User::GROUP_OPERATOR, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['create', 'view', ],
                        'roles' => [User::GROUP_OPERATOR, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete', ],
                        'roles' => [User::GROUP_OPERATOR, ],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Docdata models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DocdataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Docdata model.
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
     * Creates a new Docdata model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Docdata();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->doc_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Docdata model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->doc_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Docdata model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        if( $model->user !== null ) {
            $udModel = Userdata::find()->where(['ud_us_id' => $model->user->us_id, 'ud_doc_key' => $model->doc_key])->one();
            if( $udModel !== null ) {
                $udModel->delete();
            }
        }

        return $this->redirect(['bonusindex']);
    }

    /**
     * @return mixed
     */
    public function actionAddbonus()
    {
        $model = new Docdata();
        $uid = Yii::$app->request->getQueryParam('uid', 0);
        $comment = '';

        if( $model->load(Yii::$app->request->post()) ) {
            $uid = Yii::$app->request->getBodyParam('uid', null);
            $comment = Yii::$app->request->getBodyParam('comment', '');
            $nLen = strlen(Docdata::DOC_BONUS_PREFIX);
            $nMax = Yii::$app->db->createCommand('Select MAX(CAST(SUBSTR(doc_key, '.($nLen+1).') As UNSIGNED)) From '.Docdata::tableName().' Where SUBSTR(doc_key, 1, '.$nLen.') = :prefix', [':prefix' => Docdata::DOC_BONUS_PREFIX])->queryScalar();
            if( $nMax === null ) {
                $nMax = 0;
            }
            $model->doc_title = $comment;
            $model->doc_org_id = -1;

            if( !empty($uid) ) {

                foreach($uid As $id) {
                    $nMax += 1;
                    $model_gr = new Docdata();
                    $model_gr->attributes = $model->attributes;
                    Orderhelper::setBonusFields($model_gr, $nMax);
                    if( !$model_gr->save() ) {
                        Yii::error('Error save dop bonus: ' . print_r($model_gr->getErrors(), true) . ' attributes = ' . print_r($model_gr->attributes, true) );
                        continue;
                    }
                    $oUserdata = new Userdata();
//                    $oUserdata->loadDefaultValues();
                    $oUserdata->ud_doc_id = 0;
                    $oUserdata->ud_us_id = $id;
                    $oUserdata->ud_doc_key = $model_gr->doc_key;
                    if( !$oUserdata->save() ) {
                        Yii::error('Error save dop user bonus: ' . print_r($oUserdata->getErrors(), true) . ' attributes = ' . print_r($oUserdata->attributes, true) );
                        $model_gr->delete();
                    }
                }
                return $this->redirect(['bonusindex', ]);
            }
        }

        return $this->render('addbonus', [
            'model' => $model,
            'uid' => $uid,
            'comment' => $comment,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionBonusindex()
    {
        $searchModel = new DocdataSearch();
        $dataProvider = $searchModel->bonusSearch(Yii::$app->request->queryParams);

        return $this->render('bonusindex', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Finds the Docdata model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Docdata the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Docdata::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
