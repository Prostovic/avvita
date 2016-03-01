<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RepeatemailForm */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Повторная отправка письма с подтверждением email';

?>

<div class="user-form">
    <div class="form-group col-md-4">
        <p>Если Вы не получали письма о подтверждении Email, введите Ваш email в поле ниже и нажмите на кнопку для повторной отправки письма.</p>
    </div>

    <div class="clearfix"></div>

    <?php $form = ActiveForm::begin([
        'id' => 'repeateconfirm-form',
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

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('email')]) ?>

    <div class="clearfix"></div>

    <div class="form-group col-md-4">
        <?= Html::submitButton('Отправить повторое письмо', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

