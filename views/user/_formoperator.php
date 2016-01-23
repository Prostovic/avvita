<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

if( preg_match('|([\\d]+)\\-([\\d]+)\\-([\\d]+)|', $model->us_birth, $a) ) {
    $model->us_birth = date('d.m.Y', strtotime($model->us_birth));
}

$bClientForm = ($model->us_group != User::GROUP_OPERATOR) && ($model->us_group != User::GROUP_ADMIN);

?>

<div class="user-form">
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'options' => [
//            'class' => 'form-horizontal'
        ],
        'fieldConfig' => [
//            'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-offset-6 col-md-6\">{error}</div>",
            'template' => "{input}\n{error}",
            'options' => ['class' => 'form-group col-md-3'],
            'labelOptions'=>['class'=>'control-label col-md-6'],
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'us_fam')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_fam')]) ?>

    <?= $form->field($model, 'us_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_name')]) ?>

    <?= $form->field($model, 'us_otch')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_otch')]) ?>

    <div class="clearfix"></div>

    <?= $form->field($model, 'us_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_email')]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>

    <div class="clearfix"></div>

    <div class="form-group col-md-4">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
