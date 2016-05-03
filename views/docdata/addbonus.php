<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Docdata */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Дополнительные бонусы';
$this->params['breadcrumbs'][] = ['label' => 'Дополнительные бонусы', 'url' => ['bonusindex']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="docdata-addbonus">

    <div class="docdata-bonusform">

        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-xs-3">
                <?= $form->field($model, 'doc_summ')->textInput() ?>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

