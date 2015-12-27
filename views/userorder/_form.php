<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ord_us_id')->textInput() ?>

    <?= $form->field($model, 'ord_summ')->textInput() ?>

    <?= $form->field($model, 'ord_flag')->textInput() ?>

    <?= $form->field($model, 'ord_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
