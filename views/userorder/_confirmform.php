<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Orderitem;
use app\models\Userorder;
use app\models\User;

/* @var $this yii\web\View */
/* @var $items array  */
/* @var $order app\models\Userorder */

$this->title = 'Оформление заказа ' . $order->ord_id;
?>
<div class="backetform-view">

<?php

$form = ActiveForm::begin([
    'id' => 'backetform-form',
//        'options' => [
//            'class' => 'form-horizontal'
//        ],
    'fieldConfig' => [
          'template' => "{label}\n<div class=\"col-md-12\">{input}</div>\n<div class=\"col-md-12\">{error}</div>",
//        'template' => '<a class="btn btn-success countminus" href="#" style="float: left;"><span class="glyphicon glyphicon-minus"></span></a>'
//                    . '{input}'
//                    . '<a class="btn btn-success countplus" href="#" style="float: left;"><span class="glyphicon glyphicon-plus"></span></a>'
//                    . "<div class=\"clearfix\"></div>\n{error}",
        'options' => ['class' => 'form-group row'],
        'labelOptions'=>['class'=>'control-label col-md-12'],
    ],
//    'validationUrl' => ['userorder/validate', 'id' =>$order->ord_id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => false,
    'validateOnBlur' => false,
    'validateOnChange' => false,
    'validateOnType' => false,
    'validateOnSubmit' => true,
]);

?>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Нименование</th>
            <th>Кол-во</th>
            <?php
//                if( !$showedit ) {
            ?>
            <th>Баллы</th>
            <th>Сумма</th>
            <?php
//                }
            ?>
        </tr>
        </thead>
        <tbody>
<?php
$aPrices = [];
$nSumm = 0;
foreach($order->goods As $obItem) {
    /** @var Orderitem $obItem */
    ?>
    <tr>
        <td>
            <?php echo Html::encode($obItem->good->gd_title); ?>
        </td>
        <td class="text-right num_good">
            <?php
                echo $obItem->ordit_count;
            ?>
        </td>
        <td class="text-right one_value">
            <?php
            echo $obItem->good->gd_price;
            ?>
        </td>
        <td class="text-right comm_value">
            <?php
            $nc = $obItem->good->gd_price * $obItem->ordit_count;
            $nSumm += $nc;

            echo $nc;
            ?>
        </td>
    </tr>
<?php
}


?>
        <tr>
            <td><strong>Итого</strong></td>
            <td></td>
            <td class="text-right"></td>
            <td class="text-right comm_value">
                <?php
                echo $nSumm;
                ?>
            </td>
        </tr>

        </tbody>
    </table>

    <div class="clearfix"></div>
    <?php
        echo $form->field($order, 'ord_message')->textarea(['rows' => 6]);
    ?>
    <div class="form-group">
<?php
    /** @var User $oUser */
    $oUser = User::findOne($order->ord_us_id);
    echo $oUser ? ('<strong>Адрес доставки:</strong> ' . Html::encode($oUser->us_adr_post)) : '';
?>
    </div>
    <div class="form-group">
<?php
    echo Html::submitButton('Оформить', ['class' => 'btn btn-success', 'value'=>'confirm']);
?>
    </div>
<?php
    ActiveForm::end();
?>

</div>
