<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Org;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocdataSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
//    ['class' => 'yii\grid\SerialColumn'],

//    'doc_id',
//    'doc_key',
    'doc_date',
    'doc_title',
    [
        'class' => 'yii\grid\DataColumn',
        'attribute' => '_user',
        'value' => function ($model, $key, $index, $column) {
            return ($model->user !== null) ? Html::encode($model->user->userName) : '';
        }
    ],
//    'doc_ordernum',
//    'doc_fullordernum',
//    [
//        'class' => 'yii\grid\DataColumn',
//        'attribute' => 'doc_org_id',
//        'filter' => ArrayHelper::map(Org::getOrgList(), 'org_key', 'org_name'),
//        'value' => function ($model, $key, $index, $column) {
//            return ($model->org ? Html::encode($model->org->org_name) : '--');
//        }
//    ],
    // 'doc_org_id',
    // 'doc_title',
    // 'doc_number',
    // 'doc_summ',
    // 'doc_created',

    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view} {delete}',
    ],
];

?>
<div class="docdata-index">
    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить бонус', ['addbonus'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>

</div>
