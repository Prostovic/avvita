<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\User;
use yii\helpers\ArrayHelper;

if( !isset($uid) ) {
    $uid = null;
}

if( !isset($comment) ) {
    $comment = '';
}

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
            <div class="col-xs-6">
                <div class="form-group field-uid required">
                    <label class="control-label" for="uid">Пользователь</label>
                    <?= Html::dropDownList(
                        'uid',
                        $uid,
                        ArrayHelper::map(User::getUserList(User::GROUP_CLIENT), 'us_id', 'userName'),
                        ['class'=>"form-control", 'id'=>'uid', 'multiple' => 'multiple'])
                    ?>
                </div>
            </div>
            <div class="col-xs-3">
                <?= $form->field($model, 'doc_summ')->textInput() ?>
            </div>
            <div class="col-xs-3">
                <div class="form-group field-comment required">
                    <label class="control-label" for="comment">Комментарий</label>
                    <?= Html::input('text', 'comment', $comment, ['class'=>"form-control", 'id'=>'comment', ]) ?>
                </div>
            </div>
        </div>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

