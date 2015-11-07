<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => [
            'class' => 'form-horizontal'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-md-10\">{input}</div>\n<div class=\"col-md-offset-2 col-md-10\">{error}</div>",
            'labelOptions'=>['class'=>'control-label col-md-2'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'us_fam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_otch')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_adr_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_birth')->textInput() ?>

    <?= $form->field($model, 'us_pass')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_position')->textInput() ?>

    <?= $form->field($model, 'us_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'us_org')->textInput(['maxlength' => true]) ?>

    <?php if( false ): ?>

        <?= $form->field($model, 'us_city_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'us_org_id')->textInput(['maxlength' => true]) ?>

    <?php endif; ?>

    <?= $form->field($model, 'us_getnews')->textInput() ?>

    <?= $form->field($model, 'us_getstate')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
