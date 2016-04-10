<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

use kartik\file\FileInput;
use kartik\select2\Select2;

use app\models\Banner;

/* @var $this yii\web\View */
/* @var $model app\models\Banner */
/* @var $form yii\widgets\ActiveForm */

$pluginOptions = [
    'language' => 'ru',
    'allowedPreviewTypes' => [],
    'showUpload' => false,
    'allowedFileExtensions' => Yii::$app->params['banner.ext'],
    'maxFileSize' => Yii::$app->params['banner.maxsize'],
    'maxFileCount' => Yii::$app->params['banner.count'],
    'layoutTemplates' => [
        'actions' => '{delete}',
    ],
];

$aGroups = Banner::getAllGroups();
// echo nl2br(print_r($aGroups, true));
$optSelect2Groups = [
    'language' => 'ru',
    'data' => ArrayHelper::map($aGroups, 'bnr_group', 'bnr_group'),
    'pluginOptions' => [
//        'debug' => true,
        'tags' => true,
        'allowClear' => true,
        'minimumInputLength' => 0,
        'maximumInputLength' => 128
    ],

    'options' => [
        'multiple' => false,
        'placeholder' => 'Выберите группу ...',
    ],
];

?>

<div class="banner-form">

    <?php $form = ActiveForm::begin([
        'id' => 'banner-form',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
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

    <div class="row">
        <div class="col-xs-4">
            <?= '' // $form->field($model, 'bnr_imagepath')->textInput(['maxlength' => true]) ?>

            <?= '' // $form->field($model, 'bnr_group')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'bnr_group')->widget(Select2::classname(), $optSelect2Groups) ?>

            <?= $form->field($model, 'bnr_title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'bnr_active')->checkbox() // textInput() ?>

        </div>

        <div class="col-xs-8">
            <?= $form->field($model, 'bnr_description')->textarea(['rows' => 6]) ?>
        </div>

    <?= '' // $form->field($model, 'bnr_created')->textInput() ?>

    <?= '' // $form->field($model, 'bnr_order')->textInput() ?>
    <?= '' // $form->field($model, 'bnr_order')->textInput() ?>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <?= empty($model->bnr_imagepath) ? '' : Html::img(str_replace('\\', '/', $model->bnr_imagepath), ['style' => 'width: 100%; border: 1px solid #333333; margin-bottom: 15px;', ]) ?>
        </div>

        <div class="col-xs-8">
            <?php
            echo $form
                ->field(
                    $model,
                    'file',
                    ['template' => "{input}{error}"]
                )
                ->widget(
                    FileInput::classname(),
                    [
                        'options' => [
                            'multiple' => false,
                        ],
                        'pluginOptions' => $pluginOptions,
                    ]
                );
            ?>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="row">
        <div class="col-xs-4">
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
