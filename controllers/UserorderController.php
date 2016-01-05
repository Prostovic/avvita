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
            'model' => $this->findModel($id, ['goods']),
        ]);
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

        $model = Orderhelper::addGood($id);
        /** @var Userorder $model */
        if( $model->hasErrors() ) {
            return $this->render('error', [
                'model' => $model,
            ]);
        }

        return $this->goBack();
    }

    /**
     * @param integer $id id товара
     * @return mixed
     */
    public function actionValidate($id)
    {
        Yii::info('actionValidate($id) _POST: ' . print_r($_POST, true));
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax ) { // && $model->load(Yii::$app->request->post())
            return $this->validateOrder($id);
        }

        return [];
    }

    /**
     * @param integer $id id товара
     * @return mixed
     */
    public function validateOrder($id)
    {
        $orderId = Html::getInputId(new Userorder(), 'ord_id');
        $result = [];
        try {
            $model = $this->findModel($id);
        }
        catch( \Exception $e ) {
            $result[$orderId] = ['Не найден заказ'];
            return $result;
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
                continue;
            }
//            $obItem->load($_POST[$sFormName][$obItem->ordit_id], '');
            Yii::info('POST: ' . $oName . ' ' . ($bSet ? $_POST[$sFormName][$obItem->ordit_id]['ordit_count'] : 'NOT exists'));
            Yii::info('COUNT: ' . $obItem->ordit_gd_id . ' ('.$obItem->ordit_count.') ordered: ' . (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : '--??--'));
            if( $obItem->good->gd_number > 0 ) {
                $nRes = $obItem->good->gd_number
                    - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                    + $obItem->ordit_count
                    - ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0);
                Yii::info('nRes = ' . $nRes);
                if( $nRes < 0 ) {
                    $result[Html::getInputId($obItem, '[' . $obItem->ordit_id . ']ordit_count')] = [
                        'Максимальное количество для заказа: ' . (
                            $obItem->good->gd_number
                            - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                            + $obItem->ordit_count
                        )
                    ];
                }
            }
            $nSumm += ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0) * $obItem->good->gd_price;
            Yii::info('SUMM: ' . $nSumm . ' ('.$obItem->ordit_count . ' * ' . $obItem->good->gd_price.')');
//            $obItem
        }
        $nUserMoney = Orderhelper::calculateUserMoney($model->ord_us_id, Orderhelper::CALC_TYPE_BOTH);
//        $result[$orderId] = ['Сумма покупок: ' . $nSumm];
        if( $nSumm > $nUserMoney ) {
            if( isset($result[$orderId]) ) {
                $result[$orderId][] = 'Максимальная сумма заказа не должна превышать ' . $nUserMoney;
            }
            else {
                $result[$orderId] = ['Максимальная сумма заказа не должна превышать ' . $nUserMoney];
            }
        }

//        $result[$orderId] = ['Count: ' . count($items)];
        Yii::info(print_r($result, true));
        // $result[Html::getInputId($model, $attribute)] = $errors;
        return $result;
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
