<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GroupSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="group-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'grp_id') ?>

    <?= $form->field($model, 'grp_title') ?>

    <?= $form->field($model, 'grp_imagepath') ?>

    <?= $form->field($model, 'grp_description') ?>

    <?= $form->field($model, 'grp_active') ?>

    <?php // echo $form->field($model, 'grp_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
