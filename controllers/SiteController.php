<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Html;

use app\models\User;
use app\models\LoginForm;
use app\models\RestoreForm;
use app\models\ContactForm;
use app\models\GoodSearch;

class SiteController extends Controller
{
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new GoodSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Url::remember();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
//        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $oUser = Yii::$app->user->identity;
            /** @var app\\models\\User $oUser */
            if( Yii::$app->user->can(User::GROUP_CLIENT) ) {
                return $this->redirect(['userdata/index']);
            }
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRestore()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RestoreForm();
        if( $model->load(Yii::$app->request->post()) ) {
            if( $model->validate() ) {
                if( $model->createResetData() ) {
                    Yii::$app->session->setFlash('success', 'На Ваш адрес выслано письмо с указанием дальнйших действий по восстановлению пароля');
                }
                else {
                    Yii::$app->session->setFlash('danger', 'К сожалению');
                }
            }
            else {
                usleep(1000000);
            }
        }
        return $this->render('restore', [
            'model' => $model,
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     *
     */
    public function actionTestmail() {
        $sParam = 'email';
        $sEmail = Yii::$app->request->getQueryParam($sParam, '');
        if( empty($sEmail) ) {
            $aLink = Url::to(['site/testmail', 'email' => '123@mail.ru']);
            return $this->renderContent('Нужно указать параметр email в строке запроса, например ' . Html::a($aLink, $aLink));
        }
        else {
            $oMail = \Yii::$app->mailer
                ->compose('testmail', [])
                ->setFrom(\Yii::$app->params['fromEmail'])
                ->setTo($sEmail)
                ->setSubject('Тестовое сообщение с сайта ' . $_SERVER['HTTP_HOST']);
            \Yii::$app->mailer->sendMultiple([$oMail]);
            return $this->renderContent('Отправлено письмо на адрес ' . $sEmail);
        }
    }
}
