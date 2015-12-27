<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Userorder */

$this->title = $model->ord_id;
$this->params['breadcrumbs'][] = ['label' => 'Userorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userorder-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->ord_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->ord_id], [
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
            'ord_id',
            'ord_us_id',
            'ord_summ',
            'ord_flag',
            'ord_created',
        ],
    ]) ?>

</div>
