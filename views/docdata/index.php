<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocdataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docdatas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="docdata-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Docdata', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'doc_id',
            'doc_key',
            'dac_date',
            'doc_ordernum',
            'doc_org_id',
            // 'doc_title',
            // 'doc_number',
            // 'doc_summ',
            // 'doc_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
