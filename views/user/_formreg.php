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

    <!-- div class="width1_3">
    </div -->
    <?= $form->field($model, 'us_fam')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_fam')]) ?>

    <?= $form->field($model, 'us_name')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_name')]) ?>

    <?= $form->field($model, 'us_otch')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_otch')]) ?>

    <?= $bClientForm ? $form->field($model, 'us_position')->dropDownList($model->getPositions(), ['placeholder' => $model->getAttributeLabel('us_position')]) : '' ?>

    <div class="clearfix"></div>

    <?= $form->field($model, 'us_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_email')]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>

    <?= '' // $form->field($model, 'us_phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_phone')]) ?>
    <?= $form->field($model, 'us_phone')->widget(MaskedInput::classname(), [
        'mask' => '+7(999)999-99-99',
        'options' => ['placeholder' => $model->getAttributeLabel('us_phone'), 'class' => 'form-control', ],
    ]) ?>

    <?= '' // $form->field($model, 'us_birth', ['options' => ['class' => 'form-group col-md-3'],])->textInput(['placeholder' => $model->getAttributeLabel('us_birth')]) ?>
    <?= $form->field($model, 'us_birth')->widget(MaskedInput::classname(), [
        'mask' => '99.99.9999',
        'options' => ['placeholder' => $model->getAttributeLabel('us_birth'), 'class' => 'form-control', ],
    ]) ?>


    <div class="clearfix"></div>

    <?= $bClientForm ? $form->field($model, 'us_city')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_city')]) : '' ?>

    <?= $bClientForm ? $form->field($model, 'us_org')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_org')]) : '' ?>

    <?= $bClientForm ? $form->field($model, 'us_adr_post', ['options' => ['class' => 'form-group col-md-6'],])->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_adr_post')]) : '' ?>

    <?php if( false ): ?>

        <?= $form->field($model, 'us_city_id')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('')]) ?>

        <?= $form->field($model, 'us_org_id')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('')]) ?>

    <?php endif; ?>

    <?php if( $model->isNewRecord ): ?>
    <div class="clearfix"></div>

    <?= $form->field($model, 'us_getnews', ['options' => ['class' => 'form-group col-md-12'],])->checkbox(['label' => 'Получать информацию об акциях компании Аввита']) ?>

    <?= $form->field($model, 'us_getstate', ['options' => ['class' => 'form-group col-md-12'],])->checkbox(['label' => 'Получать информацию об изменении бонусных баллов']) ?>

    <?= $form->field($model, 'isAgree', ['options' => ['class' => 'form-group col-md-12'],])->checkbox(['label' => $model->getAttributeLabel('isAgree')]) ?>
    <?php endif; ?>

    <div class="clearfix"></div>

    <div class="form-group col-md-4">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
