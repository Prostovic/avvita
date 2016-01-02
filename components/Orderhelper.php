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

use app\models\Userorder;
use app\models\Orderitem;
use app\models\Good;

class Orderhelper {

    /**
     * @param integer $id good id
     * @return Userorder
     */
    public static function addGood($id) {

        $model = Userorder::getActiveOrder();

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


}