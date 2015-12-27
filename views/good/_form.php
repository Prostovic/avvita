<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Good */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'gd_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gd_imagepath')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gd_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'gd_price')->textInput() ?>

    <?= $form->field($model, 'gd_number')->textInput() ?>

    <?= $form->field($model, 'gd_active')->textInput() ?>

    <?= $form->field($model, 'gd_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
