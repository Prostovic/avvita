<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocdataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docdata-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'doc_id') ?>

    <?= $form->field($model, 'doc_key') ?>

    <?= $form->field($model, 'doc_date') ?>

    <?= $form->field($model, 'doc_ordernum') ?>

    <?= $form->field($model, 'doc_fullordernum') ?>

    <?php // echo $form->field($model, 'doc_org_id') ?>

    <?php // echo $form->field($model, 'doc_title') ?>

    <?php // echo $form->field($model, 'doc_number') ?>

    <?php // echo $form->field($model, 'doc_summ') ?>

    <?php // echo $form->field($model, 'doc_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
