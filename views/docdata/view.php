<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Docdata */

$this->title = $model->doc_id;
$this->params['breadcrumbs'][] = ['label' => 'Docdatas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdata-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->doc_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->doc_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'doc_id',
            'doc_key',
            'doc_date',
            'doc_ordernum',
            'doc_fullordernum',
            'doc_org_id',
            'doc_title',
            'doc_number',
            'doc_summ',
            'doc_created',
        ],
    ]) ?>

</div>
