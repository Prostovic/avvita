<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = isset($title) ? $title : 'Загрузка из файла';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-city">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'file-form',
        'method' => 'POST',
        'options' => [
            'class' => 'form-horizontal',
            'enctype' => 'multipart/form-data'
        ],
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'filename')->fileInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

