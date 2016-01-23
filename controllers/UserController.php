<?php

namespace app\controllers;

use Yii;
use yii\base\InvalidCallException;
use yii\db\Expression;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\filters\AccessControl;
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
    public $redirectAfterUpdate = null;
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
                'only' => ['index', 'view', 'confirmemail', 'register', 'testuserdata', 'update', 'profile'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['profile', ],
                        'roles' => [User::GROUP_CLIENT],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'testuserdata', 'update', 'profile', ],
                        'roles' => [User::GROUP_OPERATOR],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['confirmemail', 'register', ],
                        'roles' => ['?', User::GROUP_OPERATOR],
                    ],
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
        if( $key == '' ) {
            throw new InvalidCallException('Не указан ключ');
        }
        $model = User::findOne(['us_confirmkey' => $key]);
        /** @var $model User */
        if( $model !== null ) {
            $model->us_group = User::GROUP_CONFIRMED;
            $model->us_confirmkey = '';
            $model->us_confirm = new Expression('NOW()');
            $model->scenario = 'confirmUserEmail';

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
     * Confirm user registration
     * @return mixed
     */
    public function actionTestuserdata($id)
    {
        $model = $this->findModel($id);
        $this->modelScenario = 'testUserData';

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['user/index', ]); // 'id' => $model->us_id
//            return $this->redirect(['view', 'id' => $model->us_id]);
        } else {
            return $this->render('testuser', [
                'model' => $model,
            ]);
        }
    }

    /**
     * New user registration
     * @return mixed
     */
    public function actionRestorepass()
    {
        $model = User::findByOpkey(Yii::$app->request->getQueryParam('key', 'nokey'));

        if( $model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model->scenario = 'setnewpassword';

        if( $model->load(Yii::$app->request->post()) ) {
            $model->us_op_key = '';
            if( $model->save() ) {
                Yii::$app->session->setFlash('success', 'Новый пароль установлен');
            }
//            return $this->redirect(['view', 'id' => $model->us_id]);
//            return $this->redirect(['view', 'id' => $model->us_id]);
        }

        return $this->render('newpasswordform', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            throw new ForbiddenHttpException('У Вас нет прав для доступа к этой странице');
        }
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
     * Updates an User profile.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionProfile() {
        return $this->actionUpdate(Yii::$app->user->getId(), 'profile');
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id, $scenario = null)
    {
        $bNew = false;
        if( $id == 0 ) {
            $model = new User();
            $model->scenario = $this->modelScenario;
            $model->loadDefaultValues();
            $model->setScenarioAttr();
            $bNew = true;
        }
        else {
            $model = $this->findModel($id);
            if( Yii::$app->user->can(User::GROUP_CLIENT) ) {
                if( Yii::$app->user->getId() != $model->us_id ) {
                    throw new ForbiddenHttpException('У Вас нет прав для доступа к этой странице');
                }
                $model->scenario = 'profile';
            }
            else {
                if( $scenario !== null ) {
                    $model->scenario = $scenario;
                }
                else {
                    $model->scenario = ($model->us_group == User::GROUP_OPERATOR) || ($model->us_group == User::GROUP_ADMIN) ? 'backCreateUser' : 'testUserData';
                }
            }
        }

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if( $bNew && ($this->modelScenario == 'register') ) {
                return $this->render('register_thankyou', [
                    'model' => $model,
                ]);
            }
            else {
                if( Yii::$app->user->can(User::GROUP_OPERATOR) ) {
                    return $this->redirect(['index', ]);
//                    return $this->redirect(['view', 'id' => $model->us_id]);
                }
                else {
                    Yii::$app->session->setFlash('success', 'Данные успешно сохранены');
                    return $this->refresh();
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
