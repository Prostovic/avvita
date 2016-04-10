<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bnr_id') ?>

    <?= $form->field($model, 'bnr_active') ?>

    <?= $form->field($model, 'bnr_imagepath') ?>

    <?= $form->field($model, 'bnr_group') ?>

    <?= $form->field($model, 'bnr_title') ?>

    <?php // echo $form->field($model, 'bnr_description') ?>

    <?php // echo $form->field($model, 'bnr_created') ?>

    <?php // echo $form->field($model, 'bnr_order') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
