<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 02.01.2016
 * Time: 16:17
 */

namespace app\components;

use yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

use app\models\Userorder;
use app\models\Orderitem;
use app\models\Good;
use app\models\Userdata;
use app\models\Docdata;

class Orderhelper {
    const CALC_TYPE_INCR = 0; // начисленные баллы
    const CALC_TYPE_USED = 1; // баллы в выполненных заказах
    const CALC_TYPE_BOTH = 2; // итоговая сумма - разность между начисленными и потраченными балами в выполненных заказах

    /**
     * @param Userorder $model
     * @param integer $id good id
     * @return Userorder
     */
    public static function addGood(&$model, $id) {

//        $model = Userorder::getActiveOrder();
        $oGood = Good::findOne($id);
        if( $oGood === null ) {
            $model->addError('ord_id', 'Не найден требуемый подарок');
            return $model;
        }

        if( $oGood->gd_number > 0 ) {
            $nInOrders = self::orderedGood($id);
            if( $nInOrders >= $oGood->gd_number ) {
                $model->addError('ord_id', 'Не найдено требуемое количество подарков');
                return $model;
            }
        }

        self::appendItemToOrder($model, $oGood);

        return $model;
    }

    /**
     * @param Userorder $order
     * @param Good $good
     * @param integer $num
     */
    public static function appendItemToOrder($order, $good, $num = 1) {
        /** @var Orderitem $item */
        $item = Orderitem::findOne([
            'ordit_ord_id' => $order->ord_id,
            'ordit_gd_id' => $good->gd_id,
        ]);

        $b = false;
        if( $item !== null ) {
            $b = ($item->updateAllCounters(['ordit_count'=>$num], ['ordit_id' => $item->ordit_id]) > 0);
            if( !$b ) {
                Yii::info('Error save order item: updateAllCounters');
            }
        }
        else {
            $item = Orderitem::findOne([
                'ordit_ord_id' => 0,
                'ordit_gd_id' => 0,
            ]);

            if( $item === null ) {
                $item = new Orderitem();
            }

            $item->attributes = [
                'ordit_ord_id' => $order->ord_id,
                'ordit_gd_id' => $good->gd_id,
                'ordit_count' => $num,
            ];

            $b = $item->save();
            if( !$b ) {
                Yii::info('Error save order item: ' . print_r($item->getErrors(), true));
            }
        }
        return $b;
    }

    /**
     * @param integer $id good id
     * @return bool
     */
    public static function orderedGood($id) {
        $nInOrders = (new Query())
            ->select('SUM(ordit_count) As cou')
            ->from(Orderitem::tableName())
            ->where(['ordit_gd_id' => intval($id, 10)])
            ->scalar();
        return $nInOrders;
    }

    /**
     * Подсчет баллов у пользователя: полученных, потраченных или общий итог
     * @param int $uid
     * @param int $nType
     * @return int
     */
    public static function calculateUserMoney($uid, $nType = self::CALC_TYPE_INCR) {
        $nSumm = 0;

        if( ($nType == self::CALC_TYPE_INCR) || ($nType == self::CALC_TYPE_BOTH) ) {
            $sIncr = 'Select SUM(dt.doc_summ) As nplus'
                . ' From ' . Userdata::tableName() . ' ud, ' . Docdata::tableName() . ' dt'
                . ' Where ud.ud_us_id = ' . intval($uid, 10) . ' And dt.doc_key = ud.ud_doc_key';
            $nSumm = Yii::$app->db->createCommand($sIncr)->queryScalar();
        }

        if( ($nType == self::CALC_TYPE_USED) || ($nType == self::CALC_TYPE_BOTH) ) {
            $sDecr = 'Select SUM(od.ord_summ) As nminus'
                . ' From ' . Userorder::tableName() . ' od'
                . ' Where od.ord_flag In (' . implode(', ', [Userorder::ORDER_FLAG_COMPLETED, Userorder::ORDER_FLAG_SENDED]) . ') And od.ord_us_id = ' . intval($uid, 10);
            $nSumm += Yii::$app->db->createCommand($sDecr)->queryScalar() * ($nType == self::CALC_TYPE_BOTH ? -1 : 1);
        }
        return $nSumm;
    }

    /**
     * @param Userorder $model
     */
    public static function validateOrder(&$model) {
        $items = $model->goods;
        Yii::info('validateOrder() ' . print_r($model->attributes, true));

        // ищем сколько уже в заказах
        $aId = ArrayHelper::map($items, 'ordit_id', 'ordit_gd_id');
        $aOrdered = Orderitem::find()
            ->select('ordit_gd_id, SUM(ordit_count) as orderredcount')
            ->groupBy('ordit_gd_id')
            ->where(['ordit_gd_id' => $aId])
            ->all();
        $aCount = ArrayHelper::map($aOrdered, 'ordit_gd_id', 'orderredcount');

        $nSumm = 0; // общая стоимость заказа

        Yii::info('validateOrder() aCount = ' . print_r($aCount, true));
        Yii::info('validateOrder() _POST = ' . print_r($_POST, true));
        foreach( $items as &$obItem) {
            /** @var Orderitem $obItem */
            $sFormName = $obItem->formName();
            Yii::info('validateOrder() obItem = ' . print_r($obItem->attributes, true));
            $bSet = isset($_POST[$sFormName]) && isset($_POST[$sFormName][$obItem->ordit_id]) && isset($_POST[$sFormName][$obItem->ordit_id]['ordit_count']);
            if( !$bSet ) {
                Yii::info('validateOrder() NOT SET');
                $obItem->addError('ordit_count', 'Не найдены данные для данного элемента');
                $model->addError('ord_id', 'Ошибка поиска элемента заказа');
                continue;
            }

            $nOldCount = $obItem->ordit_count;
            $obItem->load($_POST[$sFormName][$obItem->ordit_id], '');

            if( $obItem->good->gd_number > 0 ) {
                // если есть ограничение на общее кол-во подарков,
                // проверяем на максимально возможное кол-во в заказе
                $nRes = $obItem->good->gd_number
                    - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                    + $nOldCount
                    - ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0);
                Yii::info('gd_number = '
                    . $obItem->good->gd_number
                    . ' - '
                    . (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                    . ' + '
                    . $nOldCount
                    . ' - '
                    . ($bSet ? intval($_POST[$sFormName][$obItem->ordit_id]['ordit_count'], 10) : 0)
                );
                Yii::info('nRes = ' . $nRes);
                if( $nRes < 0 ) {
                    $nMax = $obItem->good->gd_number
                        - (isset($aCount[$obItem->ordit_gd_id]) ? $aCount[$obItem->ordit_gd_id] : 0)
                        + $nOldCount;
                    $sErr = 'Максимальное количество для заказа: ' . $nMax;

                    $obItem->addError('ordit_count', $sErr);
                    $model->addError('ord_id', $obItem->good->gd_title . ': превышает допустимое количество ' . $nMax);
                }
            }

            $nSumm += $obItem->ordit_count * $obItem->good->gd_price;
        }

        $nUserMoney = self::calculateUserMoney($model->ord_us_id, self::CALC_TYPE_BOTH);
        Yii::info('validateOrder() nSumm = ' . $nSumm . ' nUserMoney = ' . $nUserMoney);

        if( $nSumm > $nUserMoney ) {
            $sErr = 'Максимальная сумма заказа не должна превышать ' . $nUserMoney;
            $model->addError('ord_id', $sErr);
        }
    }

    /**
     * @param Userorder $model
     * @return array
     */
    public static function getOrderErrors(&$model)
    {
        Yii::info('getOrderErrors()');
        $result = [];
        if( $model->hasErrors() ) {
            Yii::info('getOrderErrors() model->hasErrors = ' . print_r($model->getErrors(), true));
            foreach($model->getErrors() As $k=>$v) {
                $sId = Html::getInputId($model, $k);
                $result[$sId] = $v;
            }
        }
        foreach($model->goods As $obItem) {
            /** @var Orderitem $obItem */
            if( $obItem->hasErrors() ) {
                foreach($obItem->getErrors() As $k=>$v) {
                    $sId = Html::getInputId($obItem, '['.$obItem->ordit_id.']' . $k);
                    $result[$sId] = $v;
                    Yii::info('getOrderErrors() obItem['.$obItem->ordit_id.']->getErrors = ' . print_r($obItem->getErrors(), true));
                }
            }
        }
        Yii::info('getOrderErrors() result = ' . print_r($result, true));
        return $result;
    }
}