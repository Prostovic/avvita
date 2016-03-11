<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Group */

$this->title = $model->grp_title;
$this->params['breadcrumbs'][] = ['label' => 'Группы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- p>
        <?= '' // Html::a('Update', ['update', 'id' => $model->grp_id], ['class' => 'btn btn-primary']) ?>
        <?= '' // Html::a('Delete', ['delete', 'id' => $model->grp_id], [
//            'class' => 'btn btn-danger',
//            'data' => [
//                'confirm' => 'Are you sure you want to delete this item?',
//                'method' => 'post',
//            ],
//        ]) ?>
    </p -->

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'grp_id',
            'grp_title',
            'grp_imagepath',
            'grp_description:ntext',
            'grp_active',
            'grp_created',
            'grp_order',
        ],
    ]) ?>

</div>
