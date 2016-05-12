<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\User;
use app\models\Good;
use app\models\Group;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GoodSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Подарки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="good-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить подарок', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'gd_id',
            'gd_title',
//            'gd_imagepath',
//            'gd_description:ntext',
            'gd_price',
            'gd_number',
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'groupid',
                'format' => 'raw',
                'filter' => Group::getAllgroups(),
                'value' => function ($model, $key, $index, $column) {
                    /** @var Good $model */
                    return implode('<br />', ArrayHelper::map(
                        $model->groups,
                        'grp_id',
                        function($el) {
                            return Html::encode($el->grp_title);
                        }
                    ));
                }
            ],
            [
                'class' => 'yii\grid\DataColumn',
                'attribute' => 'ordered',
                'value' => function ($model, $key, $index, $column) {
                    /** @var Good $model */
                    return empty($model->ordered) ? '' : $model->ordered;
                }
            ],
            // 'gd_active',
            // 'gd_created',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
