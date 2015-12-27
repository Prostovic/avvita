<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserorderSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ord_id') ?>

    <?= $form->field($model, 'ord_us_id') ?>

    <?= $form->field($model, 'ord_summ') ?>

    <?= $form->field($model, 'ord_flag') ?>

    <?= $form->field($model, 'ord_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
