<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\Orderitem;
use app\models\Userorder;

/* @var $this yii\web\View */
/* @var $items array  */
/* @var $order app\models\Userorder */

if( !isset($showedit) ) {
    $showedit = true;
}

?>
<div class="backetform-view">

<?php
if( $showedit ) {
    $form = ActiveForm::begin([
        'id' => 'backetform-form',
//        'options' => [
//            'class' => 'form-horizontal'
//        ],
        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-offset-6 col-md-6\">{error}</div>",
            'template' => '<a class="btn btn-success countminus" href="#" style="float: left;"><span class="glyphicon glyphicon-minus"></span></a>'
                        . '{input}'
                        . '<a class="btn btn-success countplus" href="#" style="float: left;"><span class="glyphicon glyphicon-plus"></span></a>'
                        . "<div class=\"clearfix\"></div>\n{error}",
            'options' => ['class' => '', 'style' => 'width: 240px;'],
            'labelOptions'=>['class'=>'control-label col-md-6'],
        ],
        'validationUrl' => ['userorder/validate', 'id' =>$order->ord_id],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]);
}
?>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Нименование</th>
            <th>Кол-во</th>
            <th>Баллы</th>
            <th>Сумма</th>
            <?php
            if( $showedit ) {
                echo '<th></th>';
            }
            ?>
        </tr>
        </thead>
        <tbody>
<?php
$aPrices = [];
$nSumm = 0;
foreach($items As $obItem) {
    /** @var Orderitem $obItem */
    ?>
    <tr>
        <td>
            <?php echo Html::encode($obItem->good->gd_title); ?>
        </td>
        <td class="<?php echo $showedit ? '' : 'text-right'; ?> num_good">
            <?php
            if( $showedit ) {
//                echo Html::a(
//                    '<span class="glyphicon glyphicon-minus"></span>',
//                    '#',
//                    ['class'=>'btn btn-success countminus']
//                );
                echo $form->field($obItem, '[' . $obItem->ordit_id . ']ordit_count')->textInput(['style'=>'width: 50px; margin: 0 8px; display: inline-block; float: left;']);
//                echo Html::a(
//                    '<span class="glyphicon glyphicon-plus"></span>',
//                    '#',
//                    ['class'=>'btn btn-success countplus']
//                );
            }
            else {
                echo $obItem->ordit_count;
            }
            ?>
        </td>
        <td class="text-right one_value">
            <?php
            $aPrices[$obItem->ordit_id] = $obItem->good->gd_price;
            echo $obItem->good->gd_price;
            ?>
        </td>
        <td class="text-right comm_value">
            <?php
            $nc = ($obItem->good->gd_price * $obItem->ordit_count);
            $nSumm += $nc;

            echo $nc;
            ?>
        </td>
        <?php
            if( $showedit ) {
                echo '<td>' . Html::a('<span class="glyphicon glyphicon-remove"></span>', '#', ['class'=>'btn btn-danger deleterow']) . '</td>';
            }
        ?>
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
            <?php
                if( $showedit ) {
                    echo '<td></td>';
                }
            ?>
        </tr>

        </tbody>
    </table>

<?php
if( $showedit ) {
?>
    <div class="form-group">
        <?php
        echo $form->field($order, 'ord_id', ['template' => "{input}\n{error}"])->hiddenInput();
        //    echo $form->field($order, 'ord_id', ['template' => "{input}\n{error}"])->textInput(); // hiddenInput();
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="form-group">
<?php
    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) . ' ';
    echo Html::submitButton('Оформить', ['class' => 'btn btn-success', 'value'=>'confirm', 'name'=>'confirm']);
?>
    </div>
<?php
    ActiveForm::end();
    $sPrice = json_encode($aPrices);
    $sJs = <<<EOT
var fCountSum = function() {
    var aPrice = {$sPrice},
        nSum = 0,
        oTr = null;
    jQuery(".num_good input").each(function(index, element){
        var oInp = jQuery(this),
            sId = /^[^-]+-([\\d]+)-/.exec(oInp.attr("id"))[1],
            nCou = parseInt(oInp.val(), 10),
            tdSum = oInp.parents("td:first").siblings("td.comm_value"),
            nCalc = nCou * aPrice[sId];
        tdSum.text(nCalc);
        nSum += nCalc;
        oTr = tdSum.parent();
//        console.log(sId + " = " + nCou + " * " + aPrice[sId] + " = " + nCalc);
    });
    if( oTr !== null ) {
        oTr.parent().find("tr:last td.comm_value").text(nSum);
    }
    return nSum;
};
var fChangeCount = function(ob, nDelta) {
    var nCur = parseInt(ob.val());
    if( (nDelta < 0 && ((nCur + nDelta) >= 0)) || (nDelta > 0) ) {
        nCur = nCur + nDelta;
        ob.val(nCur)
    }
};
jQuery(".countminus, .countplus")
    .on(
        "click",
        function(event){
            event.preventDefault();
            var oLink = jQuery(this), oInp = oLink.siblings("input:first");
            if( oLink.hasClass("countminus") ) {
                fChangeCount(oInp, -1);
            }
            else {
                fChangeCount(oInp, 1);
            }
            oInp.trigger("change");
            return false;
        }
    );
jQuery(".deleterow")
    .on(
        "click",
        function(event){
            event.preventDefault();
            var oRow = jQuery(this).parents("tr:first"), oInp = oRow.find("input:first");
            oInp.val(0);
            oRow.hide();
            oInp.trigger("change");
            return false;
        }
    );
jQuery(".num_good input").on("change", function(event){
    fCountSum();
});
EOT;
$this->registerJs($sJs);
}
?>

</div>
