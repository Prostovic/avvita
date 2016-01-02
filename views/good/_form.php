<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Good */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="good-form">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
//        'options' => [
//            'class' => 'form-horizontal'
//        ],
//        'fieldConfig' => [
////            'template' => "{label}\n<div class=\"col-md-6\">{input}</div>\n<div class=\"col-md-offset-6 col-md-6\">{error}</div>",
//            'template' => "{input}\n{error}",
//            'options' => ['class' => 'form-group col-md-3'],
//            'labelOptions'=>['class'=>'control-label col-md-6'],
//        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="col-xs-6">
    <?= $form->field($model, 'gd_title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'gd_number')->textInput() ?>
    </div>

    <div class="col-xs-3">
        <?= $form->field($model, 'gd_price')->textInput() ?>
    </div>

    <?= '' // $form->field($model, 'gd_imagepath')->textInput(['maxlength' => true]) ?>

    <div class="col-xs-12">
    <?= $form->field($model, 'gd_description')->textarea(['rows' => 4]) ?>
    </div>

    <?= '' // $form->field($model, 'gd_active')->textInput() ?>

    <?= '' // $form->field($model, 'gd_created')->textInput() ?>

    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
