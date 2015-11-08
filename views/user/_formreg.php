<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
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

    <?= $form->field($model, 'us_position')->dropDownList($model->getPositions(), ['placeholder' => $model->getAttributeLabel('us_position')]) ?>

    <div class="clearfix"></div>

    <?= $form->field($model, 'us_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_email')]) ?>

    <?= $form->field($model, 'us_pass')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_pass')]) ?>

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

    <?= $form->field($model, 'us_city')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_city')]) ?>

    <?= $form->field($model, 'us_org')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_org')]) ?>

    <?= $form->field($model, 'us_adr_post', ['options' => ['class' => 'form-group col-md-6'],])->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_adr_post')]) ?>

    <?php if( false ): ?>

        <?= $form->field($model, 'us_city_id')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('')]) ?>

        <?= $form->field($model, 'us_org_id')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('')]) ?>

    <?php endif; ?>

    <div class="clearfix"></div>

    <?= $form->field($model, 'us_getnews', ['options' => ['class' => 'form-group col-md-12'],])->checkbox(['label' => 'Получать информацию об акциях компании Аввита']) ?>

    <?= $form->field($model, 'us_getstate', ['options' => ['class' => 'form-group col-md-12'],])->checkbox(['label' => 'Получать информацию об изменении бонусных баллов']) ?>

    <div class="clearfix"></div>

    <div class="form-group col-md-4">
        <?= Html::submitButton($model->isNewRecord ? 'Отправить' : 'Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
