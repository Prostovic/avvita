<?php

namespace app\controllers;

use Yii;
use app\models\Userorder;
use app\models\UserorderSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use app\models\User;
use app\models\Orderitem;
use app\components\Orderhelper;

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
                'only' => ['index', 'update', 'delete', 'list', 'append', 'view', ], // 'view', 'delete',
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'append', 'update', 'view', ],
                        'roles' => [ User::GROUP_CLIENT, ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update', 'delete', 'view', ],
                        'roles' => [ User::GROUP_OPERATOR ],
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
        $model = $this->findModel($id, ['goods']);

        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            if( ($model === null) || (Yii::$app->user->getId() != $model->ord_us_id) ) {
                throw new ForbiddenHttpException('Вы не можете просматривать данный заказ');
            }
        }

        if( Yii::$app->request->isPost && ($model->ord_flag == Userorder::ORDER_FLAG_ACTVE) ) {
            Orderhelper::validateOrder($model);
            if( count(Orderhelper::getOrderErrors($model)) == 0 ) {
                //
                if( $model->save() ) {
                    foreach($model->goods As $obItem) {
                        /** @var Orderitem $obItem */
                        if( $obItem->ordit_count < 1 ) {
                            $obItem->ordit_count = 0;
                            $obItem->ordit_gd_id = 0;
                            $obItem->ordit_ord_id = 0;
                        }
                        $obItem->save();
                    }
                    Orderhelper::getActiveOrderData(true);
                    if( isset($_POST['confirm']) ) {
                        $this->redirect(['confirm', 'id'=>$id]);
                    }
                    else {
                        $this->refresh();
                    }
                }
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id, ['goods']);

        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            if( ($model === null) || (Yii::$app->user->getId() != $model->ord_us_id) ) {
                throw new ForbiddenHttpException('Вы не можете просматривать данный заказ');
            }
        }

        if( Yii::$app->request->isPost && ($model->ord_flag == Userorder::ORDER_FLAG_ACTVE) ) {
            Orderhelper::validateOrder($model, false);
            if( count(Orderhelper::getOrderErrors($model)) == 0 ) {
                $model->ord_flag = Userorder::ORDER_FLAG_COMPLETED;
                $model->ord_message = $_POST[$model->formName()]['ord_message'];
                $model->ord_summ = $model->recalcSum();
                if( $model->save() ) {
                    Orderhelper::getActiveOrderData(true);
                    $this->redirect(['list']);
                }
            }
        }

        return $this->render('_confirmform', [
            'order' => $model,
        ]);
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function actionSend($id) {
        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            throw new ForbiddenHttpException('Вы не можете изменять данный заказ');
        }

        $model = $this->findModel($id, ['goods']);

        if( Yii::$app->request->isPost && ($model->ord_flag == Userorder::ORDER_FLAG_COMPLETED) ) {
            $model->ord_flag = Userorder::ORDER_FLAG_SENDED;
            $model->save();
        }
        $this->redirect(['index']);
    }

    /**
     *
     * @param integer $id
     * @return mixed
     */
    public function actionToedit($id)
    {
        if( !Yii::$app->user->can(User::GROUP_OPERATOR) ) {
            throw new ForbiddenHttpException('Вы не можете изменять данный заказ');
        }

        $model = $this->findModel($id, ['goods']);
        $nCou = Yii::$app
            ->db
            ->createCommand(
                'Select COUNT(*) As couactive From ' . Userorder::tableName()
                . ' Where ord_us_id = ' . $model->ord_us_id . ' And ord_flag = ' . Userorder::ORDER_FLAG_ACTVE
            )
            ->queryScalar();

        if( Yii::$app->request->isPost && ($model->ord_flag == Userorder::ORDER_FLAG_COMPLETED) And ($nCou == 0) ) {
            $model->ord_flag = Userorder::ORDER_FLAG_ACTVE;
            $model->ord_summ = 0;
            $model->save();
        }
        $this->redirect(['index']);
    }

    /**
     * Creates a new Userorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        return $this->redirect([Yii::$app->user->can(User::GROUP_OPERATOR) ? 'index' : 'list']);
//        $model = new Userorder();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect([Yii::$app->user->can(User::GROUP_OPERATOR) ? 'index' : 'list']);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
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
        Orderhelper::addGood($model, $id);
        /** @var Userorder $model */
        if( $model->hasErrors() ) {
            return $this->render('error', [
                'model' => $model,
            ]);
        }
        Orderhelper::getActiveOrderData(true);

        return $this->goBack();
    }

    /**
     * @param integer $id id товара
     * @return mixed
     */
    public function actionValidate($id)
    {
//        Yii::info('actionValidate($id) _POST: ' . print_r($_POST, true));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax ) { // && $model->load(Yii::$app->request->post())
            $result = [];
            try {
                $model = $this->findModel($id, ['goods']);
            }
            catch( \Exception $e ) {
                $result[Html::getInputId(new Userorder(), 'ord_id')] = ['Не найден заказ'];
                return $result;
            }
            Orderhelper::validateOrder($model);
            return Orderhelper::getOrderErrors($model);
//            return $this->validateOrder($id, true);
        }

        return [];
    }

    /**
     * @param integer|Userorder $id id заказа
     * @param boolean $isAjax запрос для ajax валидации, без установки ошибок в модели
     * @return mixed
     */
    public function validateOrder(&$id, $isAjax = true)
    {
        $orderId = Html::getInputId(new Userorder(), 'ord_id');
        $result = [];
        if( is_object($id) ) {
            $model = $id;
        }
        else {
            $model = null;
            try {
                $model = $this->findModel($id, ['goods']);
            }
            catch( \Exception $e ) {
                $result[$orderId] = ['Не найден заказ'];
                return $isAjax ? $result : $model;
            }
        }

        $items = $model->goods;
        $aId = ArrayHelper::map($items, 'ordit_id', 'ordit_gd_id');
        $aOrdered = Orderitem::find()
            ->select('ordit_gd_id, SUM(ordit_count) as orderredcount')
            ->groupBy('ordit_gd_id')
            ->where(['ordit_gd_id' => $aId])
            ->all();
        $aCount = ArrayHelper::map($aOrdered, 'ordit_gd_id', 'orderredcount');
        $nSumm = 0;
//        Yii::info(print_r($items, true));
        foreach( $items as $obItem) {
            /** @var Orderitem $obItem */
            $sFormName = $obItem->formName();
            $oName = Html::getInputName($obItem, '[' . $obItem->ordit_id . ']ordit_count');
            $bSet = isset($_POST[$sFormName]) && isset($_POST[$sFormName][$obItem->ordit_id]) && isset($_POST[$sFormName][$obItem->ordit_id]['ordit_count']);
            if( !$bSet ) {
                if( !$isAjax ) {
                    $obItem->addError('ordit_count', 'Не найдены данные для данного элемента');
                    $model->addError('ord_id', 'Ошибка поиска элемента заказа');
                }
                continue;
            }
            if( !$isAjax ) {
                $obItem->load($_POST[$sFormName][$obItem->ordit_id], '');
            }

//            Yii::info('POST: ' . $oName . ' ' . ($bSet ? $_POST[$sFormName][$obItem->ordit_id]['ordit_count'] : 'NOT exists'));
//            Yii::info('COUNT: ' . $obItem->ordit_gd_id . ' ('.$obItem->ordit_count.') ordered: ' . (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : '--??--'));
            if( $obItem->good->gd_number > 0 ) {
                $nRes = $obItem->good->gd_number
                    - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                    + $obItem->ordit_count
                    - ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0);
//                Yii::info('nRes = ' . $nRes);
                if( $nRes < 0 ) {
                    $nMax = $obItem->good->gd_number
                        - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                        + $obItem->ordit_count;
                    $sErr = 'Максимальное количество для заказа: ' . $nMax;
                    if( !$isAjax ) {
                        $obItem->addError('ordit_count', $sErr);
                        $model->addError('ord_id', $obItem->good->gd_title . ': превышает допустимое количество ' . $nMax);
                    }
                    $result[Html::getInputId($obItem, '[' . $obItem->ordit_id . ']ordit_count')] = [$sErr];
                }
            }
            $nSumm += ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0) * $obItem->good->gd_price;
//            Yii::info('SUMM: ' . $nSumm . ' ('.$obItem->ordit_count . ' * ' . $obItem->good->gd_price.')');
//            $obItem
        }
        $nUserMoney = Orderhelper::calculateUserMoney($model->ord_us_id, Orderhelper::CALC_TYPE_BOTH);
//        $result[$orderId] = ['Сумма покупок: ' . $nSumm];
        if( $nSumm > $nUserMoney ) {
            $sErr = 'Максимальная сумма заказа не должна превышать ' . $nUserMoney;
            if( isset($result[$orderId]) ) {
                $result[$orderId][] = $sErr;
            }
            else {
                $result[$orderId] = [$sErr];
            }
            if( !$isAjax ) {
                $model->addError('ord_id', $sErr);
            }
        }

//        $result[$orderId] = ['Count: ' . count($items)];
        Yii::info(print_r($isAjax ? $result : $model->getErrors(), true));
        // $result[Html::getInputId($model, $attribute)] = $errors;
        return $isAjax ? $result : $model;
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
        return $this->redirect([Yii::$app->user->can(User::GROUP_OPERATOR) ? 'index' : 'list']);
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Userorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $with = [])
    {
        $model = Userorder::find()
            ->where(['ord_id' => $id])
            ->with($with)
            ->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
