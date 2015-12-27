<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Orderitem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orderitem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ordit_ord_id')->textInput() ?>

    <?= $form->field($model, 'ordit_gd_id')->textInput() ?>

    <?= $form->field($model, 'ordit_count')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
