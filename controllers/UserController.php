<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

use app\models\User;
use app\models\UserSearch;
use app\components\Notificator;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    public $modelScenario = 'register';
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionRegister()
    {
        $this->modelScenario = 'register';
        return $this->actionUpdate(0);
    }

    /**
     * Confirm user registration
     * @return mixed
     */
    public function actionConfirmemail($key = '')
    {
        $model = User::findOne(['us_confirmkey' => $key]);
        if( $model !== null ) {
            $model->us_group = User::GROUP_CONFIRMED;
            $model->us_confirmkey = '';
            if( $model->save() ) {
                $oNotify = new Notificator(
                    User::findAll(['us_group' => [User::GROUP_ADMIN, User::GROUP_OPERATOR,] ]),
                    $model,
                    'newuserreg_mail'
                );
                $oNotify->notifyMail('Новый пользователь на портале "' . Yii::$app->name . '"');
            }
            else {
                Yii::info('Error save User Confirmemail: ' . print_r($model->getErrors(), true));
            }
        }
        return $this->render('confirm_email', ['model' => $model]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->modelScenario = 'backCreateUser';
        return $this->actionUpdate(0);
/*
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->us_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
*/
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if( $id == 0 ) {
            $model = new User();
            $model->scenario = $this->modelScenario;
            $model->loadDefaultValues();
        }
        else {
            $model = $this->findModel($id);
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->us_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
