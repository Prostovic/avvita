<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\DataColumn;

use app\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <!-- h1><?= '' // Html::encode($this->title) ?></h1 -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= '' //Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'us_id',
//            'us_active',
            [
                'class' => DataColumn::className(),
                'attribute' => 'us_fam',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    return $model->userName
                    . '<br />'
                    . $model->us_email
                    . '<br />'
                    . $model->us_phone;
                },
            ],
            [
                'class' => DataColumn::className(),
                'attribute' => 'docSumm',
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {
                    /** @var User $model */
                    return
                        ($model->docSumm > 0 ? Html::a('Начислено', ['userdata/index', 'UserdataSearch' => ['ud_us_id' => $model->us_id]]) : 'Начислено')
                        . ': '
                        . (empty($model->docSumm) ? '-' : $model->docSumm)
                        . '<br />'
                        . ($model->orderSumm > 0 ? Html::a('Потрачено', ['userorder/index', 'UserorderSearch' => ['ord_us_id' => $model->us_id]]) : 'Потрачено')
                        . ': '
                        . (empty($model->orderSumm) ? '-' : $model->orderSumm)
                        . '<br />'
                        . 'Итог: ' . ($model->docSumm - $model->orderSumm);
                },
            ],
        ],
    ]); ?>

</div>
