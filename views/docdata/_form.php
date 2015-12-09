<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Docdata */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="docdata-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'doc_key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'dac_date')->textInput() ?>

    <?= $form->field($model, 'doc_ordernum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_org_id')->textInput() ?>

    <?= $form->field($model, 'doc_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_number')->textInput() ?>

    <?= $form->field($model, 'doc_summ')->textInput() ?>

    <?= $form->field($model, 'doc_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
