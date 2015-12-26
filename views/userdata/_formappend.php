<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Userdata */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userdata-form">

    <?php $form = ActiveForm::begin([
        'id' => 'append-form',
//        'options' => [
//            'class' => 'lio_f_val'
//        ],
//        'fieldConfig' => [
//            'template' => "{input}\n{error}",
//            'template' => '{label}{input}{error}',
//            'options' => ['class' => 'form-group'],
//            'labelOptions'=>['class'=>'control-label col-md-6'],
//        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <?= $form->field($model, 'ordernum')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Добавить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
