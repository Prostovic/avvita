<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userorder-form">

    <?php $form = ActiveForm::begin([
        'id' => 'order-form',
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <?= '' // $form->field($model, 'ord_us_id')->textInput() ?>

    <?= '' // $form->field($model, 'ord_summ')->textInput() ?>

    <?= '' // $form->field($model, 'ord_flag')->textInput() ?>

    <?= '' // $form->field($model, 'ord_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
