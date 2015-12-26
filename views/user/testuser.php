<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use app\models\City;
use app\models\Org;
use app\models\User;

use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Проверка данных пользователя';
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = ['label' => $model->us_id, 'url' => ['view', 'id' => $model->us_id]];
$this->params['breadcrumbs'][] = $this->title;

$model->us_group = User::GROUP_CLIENT;

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

    <?= $form->field($model, 'us_position')->dropDownList($model->getPositions(), ['placeholder' => $model->getAttributeLabel('us_position')]) ?>

    <div class="clearfix"></div>

    <?= $form->field($model, 'us_email')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_email')]) ?>

    <?= $form->field($model, 'password')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('password')]) ?>

    <?= '' // $form->field($model, 'us_phone')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_phone')]) ?>
    <?= $form->field($model, 'us_phone')->widget(MaskedInput::classname(), [
        'mask' => '+7(999)999-99-99',
        'options' => ['placeholder' => $model->getAttributeLabel('us_phone'), 'class' => 'form-control', ],
    ]) ?>

    <?= '' // $form->field($model, 'us_birth', ['options' => ['class' => 'form-group col-md-3'],])->textInput(['placeholder' => $model->getAttributeLabel('us_birth')]) ?>
    <?php
        $model->us_birth = date('d.m.Y', strtotime($model->us_birth));
    ?>
    <?= $form->field($model, 'us_birth')->widget(MaskedInput::classname(), [
        'mask' => '99.99.9999',
        'options' => ['placeholder' => $model->getAttributeLabel('us_birth'), 'class' => 'form-control', ],
    ]) ?>


    <div class="clearfix"></div>

    <?= $form->field($model, 'us_city')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_city')]) ?>

    <?= $form->field($model, 'us_org')->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_org')]) ?>

    <?= $form->field($model, 'us_adr_post', ['options' => ['class' => 'form-group col-md-6'],])->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('us_adr_post')]) ?>

    <div class="clearfix"></div>

    <?= '' // $form->field($model, 'us_city_id')->dropDownList(City::getCities(), ['placeholder' => $model->getAttributeLabel('us_city_id')]) ?>
    <?= $form->field($model, 'us_city_id')->widget(Select2::classname(), [
        'data' => City::getCities(),
        'language' => 'ru',
        'options' => ['placeholder' => $model->getAttributeLabel('us_city_id')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])  ?>

    <?= '' // $form->field($model, 'us_org_id')->dropDownList(Org::getCities(), ['placeholder' => $model->getAttributeLabel('')]) ?>
    <?= $form->field($model, 'us_org_id')->widget(Select2::classname(), [
        'data' => Org::getList(),
        'language' => 'ru',
        'options' => ['placeholder' => $model->getAttributeLabel('us_org_id')],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

    <div class="clearfix"></div>

    <?= '' // $form->field($model, 'us_active')->textInput() ?>

    <?= '' // $form->field($model, 'us_fam')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_name')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_otch')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_email')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_phone')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_adr_post')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_birth')->textInput() ?>

    <?= '' // $form->field($model, 'us_pass')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_position')->textInput() ?>

    <?= '' // $form->field($model, 'us_city')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_org')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_city_id')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_org_id')->textInput(['maxlength' => true]) ?>

    <?= '' // $form->field($model, 'us_created')->textInput() ?>

    <?= '' // $form->field($model, 'us_confirm')->textInput() ?>

    <?= '' // $form->field($model, 'us_activate')->textInput() ?>

    <?= '' // $form->field($model, 'us_getnews')->textInput() ?>

    <?= '' // $form->field($model, 'us_getstate')->textInput() ?>

    <div class="form-group col-md-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>
    <?= $form->field($model, 'us_group')->hiddenInput() ?>

    <?php ActiveForm::end(); ?>

</div>
