<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\GoodimgSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goodimg-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'gi_id') ?>

    <?= $form->field($model, 'gi_gd_id') ?>

    <?= $form->field($model, 'gi_path') ?>

    <?= $form->field($model, 'gi_title') ?>

    <?= $form->field($model, 'gi_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
