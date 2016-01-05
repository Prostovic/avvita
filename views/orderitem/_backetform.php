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
                        . "\n{error}",
            'options' => ['class' => 'form-group col-md-6'],
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
?>
    <div class="form-group">
<?php
//    echo $form->field($order, 'ord_id', ['template' => "{input}\n{error}"])->hiddenInput();
    echo $form->field($order, 'ord_id', ['template' => "{input}\n{error}"])->textInput(); // hiddenInput();
?>
    </div>
<?php
}
?>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Нименование</th>
            <th>Кол-во</th>
            <?php
                if( !$showedit ) {
            ?>
            <th>Баллы</th>
            <?php
                }
            ?>
        </tr>
        </thead>
        <tbody>
<?php
foreach($items As $obItem) {
    /** @var Orderitem $obItem */
    ?>
    <tr>
        <td>
            <?php echo Html::encode($obItem->good->gd_title); ?>
        </td>
        <td class="<?php echo $showedit ? '' : 'text-right'; ?>">
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
        <?php
        if( !$showedit ) {
            ?>
            <td class="text-right">
                <?php
                echo $obItem->ordit_count
                    . ' * '
                    . $obItem->good->gd_price
                    . ' = '
                    . ($obItem->good->gd_price * $obItem->ordit_count);
                ?>
            </td>
        <?php
        }
        ?>
    </tr>
<?php
}


?>
        </tbody>
    </table>

<?php
if( $showedit ) {
?>
    <div class="form-group">
<?php
    echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']);
?>
    </div>
<?php
    ActiveForm::end();
    $sJs = <<<EOT
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
            return false;
        }
    );
EOT;
$this->registerJs($sJs);
}
?>

</div>
