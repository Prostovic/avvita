<?php
/**
 * Created by PhpStorm.
 * User: Vik
 * Date: 09.11.2015
 * Time: 0:17
 */

//use yii;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Orderitem;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $data app\models\Userorder */

$aLink = ['userorder/view', 'id' => $data->ord_id];

/* @var $oUser app\models\User */
$oUser = User::findOne($data->ord_us_id);

?>

<p>Здравствуйте, <?= Html::encode($model->getUserName(true)) ?>.</p>

<p>На сайте <?= Yii::$app->name ?> создан новый заказ <?php echo Html::a(Url::to($aLink, true), Url::to($aLink, true)); ?>.</p>

<p>Пользователь <?= $oUser->getUserName() ?>, адрес доставки <?php echo Html::encode($oUser->us_adr_post); ?>.</p>

<p>Состав заказа</p>

<table cellpadding="6" cellspacing="1">
    <tr>
        <td>Наименование</td>
        <td>Кол-во</td>
        <td>Цена</td>
        <td>Сумма</td>
    </tr>
    <?php
    $nSumm = 0;
    foreach($data->goods As $obItem) {
    ?>
    <tr>
        <td><?php echo Html::encode($obItem->good->gd_title); ?></td>
        <td><?php echo $obItem->ordit_count; ?></td>
        <td><?php echo $obItem->good->gd_price; ?></td>
        <td><?php
            $nc = ($obItem->good->gd_price * $obItem->ordit_count);
            $nSumm += $nc;

            echo $nc;
            ?></td>
    </tr>
    <?php
    }
    ?>
    <tr>
        <td>Итого</td>
        <td></td>
        <td></td>
        <td><?php echo $nSumm; ?></td>
    </tr>
</table>

