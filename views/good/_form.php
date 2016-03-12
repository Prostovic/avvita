<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\View;

use kartik\file\FileInput;

use app\models\Goodimg;
use app\models\Group;

/* @var $this yii\web\View */
/* @var $model app\models\Good */
/* @var $form yii\widgets\ActiveForm */

$pluginOptions = [
    'language' => 'ru',
    'allowedPreviewTypes' => [],
    'showUpload' => false,
    'allowedFileExtensions' => Yii::$app->params['image.ext'],
    'maxFileSize' => Yii::$app->params['image.maxsize'],
    'maxFileCount' => Yii::$app->params['image.count'],
    'layoutTemplates' => [
        'actions' => '{delete}',
    ],
];
?>

<div class="good-form">

    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
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

    <div class="col-xs-3">
    <?= $form->field($model, 'gd_title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-xs-3">
    <?= $form->field($model, 'groupid')->dropDownList(Group::getAllgroups()) ?>
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
    <?php
    $aImages = $model->images;
    if( count($aImages) > 0 ) {
        // не заморачиваемся с существующими файлами - делаем отдельные ссылки на удаление
        $aPrev = [];
        $aConf = [];
        echo '<div class="row form-group">';
        foreach($aImages As $ob) {
            /** @var Goodimg $ob */
//            $aPrev[] =
//                '<div class="file-preview-other-frame">'
//                . '<div class="file-preview-other">'
//                . '<span class="file-icon-4x"><i class="glyphicon glyphicon-file"></i></span>'
//                . '</div>'
//                . '</div>'
//                . '<div class="file-preview-other-footer">'
//                . '<div class="file-thumbnail-footer">'
//                . '<div class="file-footer-caption" title="'.basename($ob->gi_path).'">'.basename($ob->gi_path).'</div>'
//                . '</div>'
//                . '</div>';
//
//            $aConf[] = [
//                'caption' => basename($ob->gi_path),
//                'url' => Url::to([Yii::$app->controller->getUniqueId() . '/deletefile', 'fileid' => $ob->gi_id]),
//                'key' => $ob->gi_id,
//                'extra' => [
//                    'good' => $model->gd_id,
//                ],
//            ];

            echo '<div class="col-xs-4 image-edit-region">' . Html::img(
                    substr(Yii::getAlias('@webroot'), strlen($_SERVER['DOCUMENT_ROOT'])) . str_replace(['/', '\\'], ['/', '/'], $ob->gi_path)
                )
                . ''
                . Html::a(
                    '<i class="glyphicon glyphicon-remove"></i>',
                    [Yii::$app->controller->getUniqueId() . '/deletefile', 'id' => $model->gd_id, 'fileid' => $ob->gi_id],
                    [
                        'class' => 'post-request-link-delete-file',
                    ]
                )
                . '</div>';

        }
        echo '</div><div class="clearfix"></div></div><div class="col-xs-12">';

//        echo '<div class="form-file-region" style="display: none;">';
        $sJs = <<<EOT
jQuery(".post-request-link-delete-file").on(
    "click",
    function(event) {
        event.preventDefault();
        var oLink = jQuery(this),
            oParent = oLink.parent();
        jQuery.ajax({
            dataType: "json",
            url: oLink.attr("href"),
            data: {},
            success: function(data, textStatus, jqXHR) {
                if( !("error" in data) ) {
                    oParent.fadeOut();
                    jQuery(".form-file-region").fadeIn();
                }
            }
        });
        return false;
    }
);
EOT;
        $this->registerJs($sJs, View::POS_READY, 'upload-file-action');

//    $pluginOptions['initialPreview'] = $aPrev;
//    $pluginOptions['initialPreviewConfig '] = $aConf;
    }

    $bMultiple = Yii::$app->params['image.count'] > 1;
    echo $form
        ->field(
            $model,
            'file' . ($bMultiple ? '[]' : ''),
            ['template' => "{input}{error}"]
        )
        ->widget(
            FileInput::classname(),
            [
                'options' => [
                    'multiple' => $bMultiple ? 'multiple' : false,
                ],
                'pluginOptions' => $pluginOptions,
            ]
        );

    if( count($aImages) > 0 ) {
//        echo '</div>';
    }
    ?>
    </div>

    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
