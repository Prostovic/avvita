<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Goodimg */

$this->title = $model->gi_id;
$this->params['breadcrumbs'][] = ['label' => 'Goodimgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodimg-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->gi_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->gi_id], [
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
            'gi_id',
            'gi_gd_id',
            'gi_path',
            'gi_title',
            'gi_created',
        ],
    ]) ?>

</div>
