<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Docdata */

$this->title = 'Начисление ' . $model->doc_id;
//$this->params['breadcrumbs'][] = ['label' => 'Docdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
if( $model->doc_org_id == -1 ) {
    $aAttrib = [
//        'doc_id',
        [
            'label' => 'Пользователь',
            'value' => ($model->user !== null) ? $model->user->userName : '', // print_r($model->user->attributes, true),
        ],
        'doc_title',
        'doc_summ',
        'doc_created',
    ];
}
else {
    $aAttrib = [
//        'doc_id',
        'doc_key',
        'doc_date',
        'doc_ordernum',
        'doc_fullordernum',
        [
            'attribute' => 'doc_org_id',
            'value' => $model->org->org_name,
        ],
        [
            'label' => 'Пользователь',
            'value' => print_r($model->user->attributes, true),
        ],
//        'doc_org_id',
        'doc_title',
        'doc_number',
        'doc_summ',
//        'doc_created',
    ];
}
// $model->getUser

?>
<div class="docdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- p>
        <?= '' // Html::a('Update', ['update', 'id' => $model->doc_id], ['class' => 'btn btn-primary']) ?>
        <?= '' /* Html::a('Delete', ['delete', 'id' => $model->doc_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) */ ?>
    </p -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $aAttrib,
    ]) ?>

</div>
