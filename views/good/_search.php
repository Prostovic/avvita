<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gd_id') ?>

    <?= $form->field($model, 'gd_title') ?>

    <?= $form->field($model, 'gd_imagepath') ?>

    <?= $form->field($model, 'gd_description') ?>

    <?= $form->field($model, 'gd_price') ?>

    <?php // echo $form->field($model, 'gd_number') ?>

    <?php // echo $form->field($model, 'gd_active') ?>

    <?php // echo $form->field($model, 'gd_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
