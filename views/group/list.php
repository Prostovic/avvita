<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Группы подарков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="group-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить группу', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'grp_id',
            'grp_title',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'grp_imagepath',
                'filter' => false,
                'format' => 'raw',
                'value' => function ($model, $key, $index, $column) {
                    /** @var $model app\models\Group */
                    return Html::img($model->grp_imagepath, ['alt' => $model->grp_title]);
                },
            ],
//            'grp_imagepath',
//            'grp_description:ntext',
//            'grp_active',
            // 'grp_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
