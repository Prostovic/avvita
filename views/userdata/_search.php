<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserdataSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userdata-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'ud_id') ?>

    <?= $form->field($model, 'ud_doc_id') ?>

    <?= $form->field($model, 'ud_us_id') ?>

    <?= $form->field($model, 'ud_created') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
