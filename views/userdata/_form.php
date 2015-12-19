<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userdata-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ud_doc_id')->textInput() ?>

    <?= $form->field($model, 'ud_us_id')->textInput() ?>

    <?= $form->field($model, 'ud_created')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
