<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\View;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Group */
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

<div class="group-form">

    <?php $form = ActiveForm::begin([
        'id' => 'group-edit-form',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
        'enableAjaxValidation' => true,
        'enableClientValidation' => false,
        'validateOnBlur' => false,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="col-xs-8">
        <?= $form->field($model, 'grp_title')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-xs-2">
        &nbsp;
    </div>

    <div class="col-xs-2">
        <?= $form->field($model, 'grp_active', ['template' => '<label class="control-label">&nbsp;</label><br />{input}{error}'])->checkbox() ?>
    </div>

    <?= '' // $form->field($model, 'grp_imagepath')->textInput(['maxlength' => true]) ?>

    <div class="col-xs-12">
        <?= $form->field($model, 'grp_description')->textarea(['rows' => 4]) ?>
    </div>

    <div class="col-xs-12">
        <?php
        if( !empty($model->grp_imagepath) ) {
            // не заморачиваемся с существующими файлами - делаем отдельные ссылки на удаление
            $aPrev = [];
            $aConf = [];
            echo '<div class="row form-group">';
//            foreach($aImages As $ob) {
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
                        substr(Yii::getAlias('@webroot'), strlen($_SERVER['DOCUMENT_ROOT'])) . str_replace(['/', '\\'], ['/', '/'], $model->grp_imagepath)
                    )
                    . ''
                    . Html::a(
                        '<i class="glyphicon glyphicon-remove"></i>',
                        [Yii::$app->controller->getUniqueId() . '/deletefile', 'id' => $model->grp_id, ],
                        [
                            'class' => 'post-request-link-delete-file',
                        ]
                    )
                    . '</div>';

//            }
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

    <?= '' // $form->field($model, 'grp_active')->textInput() ?>

    <?= '' // $form->field($model, 'grp_created')->textInput() ?>

    <div class="col-xs-12">
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
