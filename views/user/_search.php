<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'us_id') ?>

    <?= $form->field($model, 'us_active') ?>

    <?= $form->field($model, 'us_fam') ?>

    <?= $form->field($model, 'us_name') ?>

    <?= $form->field($model, 'us_otch') ?>

    <?php // echo $form->field($model, 'us_email') ?>

    <?php // echo $form->field($model, 'us_phone') ?>

    <?php // echo $form->field($model, 'us_adr_post') ?>

    <?php // echo $form->field($model, 'us_birth') ?>

    <?php // echo $form->field($model, 'us_pass') ?>

    <?php // echo $form->field($model, 'us_position') ?>

    <?php // echo $form->field($model, 'us_city') ?>

    <?php // echo $form->field($model, 'us_org') ?>

    <?php // echo $form->field($model, 'us_city_id') ?>

    <?php // echo $form->field($model, 'us_org_id') ?>

    <?php // echo $form->field($model, 'us_created') ?>

    <?php // echo $form->field($model, 'us_confirm') ?>

    <?php // echo $form->field($model, 'us_activate') ?>

    <?php // echo $form->field($model, 'us_getnews') ?>

    <?php // echo $form->field($model, 'us_getstate') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
