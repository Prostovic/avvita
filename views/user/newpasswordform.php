<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Установка нового пароля';

?>

<div class="user-form">

    <?php
        if( !Yii::$app->session->hasFlash('success') ) {
            $form = ActiveForm::begin([
                'id' => 'restore-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    'labelOptions' => ['class' => 'col-lg-1 control-label'],
                ],
            ]); ?>

            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Установить новый пароль', ['class' => 'btn btn-success']) ?>
            </div>

    <?php
            ActiveForm::end();
        }
    ?>

</div>
