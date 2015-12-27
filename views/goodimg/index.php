<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodimgSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Goodimgs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goodimg-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goodimg', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gi_id',
            'gi_gd_id',
            'gi_path',
            'gi_title',
            'gi_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
